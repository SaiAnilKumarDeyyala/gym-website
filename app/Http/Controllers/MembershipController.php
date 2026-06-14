<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function create(\Illuminate\Http\Request $request, Member $member)
    {
        // Allow scheduling renewals: if a start_date is provided and is AFTER the active end_date, allow.
        $active = $member->memberships()->where('status', 'active')->where('start_date', '<=', now()->toDateString())->orderByDesc('end_date')->first();

        if ($active && $active->end_date) {
            $requestedStart = $request->query('start_date');
            if ($requestedStart) {
                $requested = Carbon::parse($requestedStart)->startOfDay();
                // allow if requested start is after active end_date
                if ($requested->gt($active->end_date->startOfDay())) {
                    // Also ensure there's no existing future/scheduled membership that overlaps
                    $futureMemberships = $member->memberships()->whereDate('start_date', '>', now()->toDateString())->get();
                    foreach ($futureMemberships as $existing) {
                        if (! $existing->start_date || ! $existing->end_date) {
                            continue;
                        }
                        $existingStart = Carbon::parse($existing->start_date)->startOfDay();
                        $existingEnd = Carbon::parse($existing->end_date)->startOfDay();
                        // requested end = requested + duration if provided via query params (optional)
                        $requestedEnd = $requested->copy();
                        if ($request->query('duration_days')) {
                            $requestedEnd = $requestedEnd->addDays((int) $request->query('duration_days'));
                        }
                        if ($existingStart->lte($requestedEnd) && $existingEnd->gte($requested)) {
                            return redirect()->route('members.index')
                                ->with('error', 'A scheduled membership already exists for this member that overlaps ' . $existingStart->format('Y-m-d') . ' – ' . $existingEnd->format('Y-m-d'));
                        }
                    }

                    return view('memberships.create', compact('member'));
                }
            }

            // No valid schedule requested — block if current active hasn't expired yet
            if ($active->end_date->gte(now()->startOfDay())) {
                return redirect()->route('members.index')
                    ->with('error', 'Cannot renew membership until current plan expires on ' . $active->end_date->format('Y-m-d'));
            }
        }

        return view('memberships.create', compact('member'));
    }

    public function store(Request $request, Member $member)
    {
        $validated = $request->validate([
            'plan_name' => ['required', 'string', 'max:255'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date'],
            'payment_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Prevent creating a new membership that starts before the current active membership ends
        $active = $member->memberships()->where('status', 'active')->where('start_date', '<=', now()->toDateString())->orderByDesc('end_date')->first();
        if ($active && $active->end_date) {
            $requestedStart = Carbon::parse($validated['start_date'])->startOfDay();
            if ($requestedStart->lte($active->end_date->startOfDay())) {
                return redirect()->route('members.index')
                    ->with('error', 'Cannot create a new membership that starts before the current plan expires on ' . $active->end_date->format('Y-m-d'));
            }
        }

        // Prevent creating overlapping scheduled memberships for the same member.
        // Any existing membership with a start_date in the future that overlaps the
        // requested start..end window should block the creation.
        $requestedStart = Carbon::parse($validated['start_date'])->startOfDay();
        $requestedEnd = $requestedStart->copy()->addDays((int) $validated['duration_days'])->startOfDay();

        $futureMemberships = $member->memberships()->whereDate('start_date', '>', now()->toDateString())->get();
        foreach ($futureMemberships as $existing) {
            if (! $existing->start_date || ! $existing->end_date) {
                continue;
            }

            $existingStart = Carbon::parse($existing->start_date)->startOfDay();
            $existingEnd = Carbon::parse($existing->end_date)->startOfDay();

            // Overlap check: (existingStart <= requestedEnd) && (existingEnd >= requestedStart)
            if ($existingStart->lte($requestedEnd) && $existingEnd->gte($requestedStart)) {
                return redirect()->route('members.index')
                    ->with('error', 'A scheduled membership for this member already exists that overlaps the requested period (' . $existingStart->format('Y-m-d') . ' – ' . $existingEnd->format('Y-m-d') . ').');
            }
        }

        $duration = (int) $validated['duration_days'];
        $endDate = Carbon::parse($validated['start_date'])->addDays($duration);

        // If payment_amount not supplied, infer from known SK Fitness prices
        $prices = [
            'Offer - 1 Month Strength' => 1299,
            'Offer - 1 Month Cardio+Strength' => 1599,
            'Offer - 3 Months Strength' => 3499,
            'Offer - 3 Months Cardio+Strength' => 4499,
            '1 Month Strength' => 1399,
            '1 Month Cardio+Strength' => 1799,
            '3 Months Strength' => 3999,
            '3 Months Cardio+Strength' => 4999,
            '6 Months Strength' => 6999,
            '6 Months Cardio+Strength' => 8999,
            '12 Months Strength' => 11999,
            '12 Months Cardio+Strength' => 13999,
        ];

        // We store only the allowed enum values: use 'active' even for future-starting memberships
        // and treat "scheduled" behavior via the `start_date`.
        $status = 'active';

        $member->memberships()->create([
            'plan_name' => $validated['plan_name'],
            'duration_days' => $duration,
            'start_date' => $validated['start_date'],
            'end_date' => $endDate->toDateString(),
            'status' => $status,
            'payment_amount' => $validated['payment_amount'] ?? ($prices[$validated['plan_name']] ?? null),
        ]);

        // Clear cached dashboard values so revenue updates immediately
        Cache::forget('dashboard.revenue_this_month');
        Cache::forget('dashboard.expiring_soon');

        return redirect()->route('members.index')->with('success', 'Membership plan successfully assigned!');
    }
}
