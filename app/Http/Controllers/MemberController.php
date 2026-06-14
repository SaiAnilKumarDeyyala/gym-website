<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index()
    {
        // 'with' eagerly loads the related memberships, sorted by newest end_date
        $members = Member::with(['memberships' => function($query) {
            $query->latest('end_date');
        }])->latest()->get();

        // upcoming scheduled memberships (start_date in the future)
        // Fetch upcoming items, order by start_date ascending, then ensure we only show
        // one upcoming scheduled membership per member (the earliest one).
        $upcomingScheduled = \App\Models\Membership::with('member')
            ->whereDate('start_date', '>', now()->toDateString())
            ->orderBy('start_date')
            ->get()
            ->unique('member_id')
            ->values()
            ->take(10);

        return view('members.index', compact('members', 'upcomingScheduled'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        // 1. Validate both Member AND Membership data
        $validated = $request->validate([
            'member_code' => ['required', 'string', 'max:255', 'unique:members,member_code'],
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:20', 'unique:members,phone'],
            'plan_name'   => ['required', 'string'],
            'start_date'  => ['required', 'date'],
        ]);

        // 2. Map SK Fitness Plans to Duration in Days and Prices
        $durations = [
            'Offer - 1 Month Strength' => 30,
            'Offer - 1 Month Cardio+Strength' => 30,
            'Offer - 3 Months Strength' => 90,
            'Offer - 3 Months Cardio+Strength' => 90,
            '1 Month Strength' => 30,
            '1 Month Cardio+Strength' => 30,
            '3 Months Strength' => 90,
            '3 Months Cardio+Strength' => 90,
            '6 Months Strength' => 180,
            '6 Months Cardio+Strength' => 180,
            '12 Months Strength' => 365,
            '12 Months Cardio+Strength' => 365,
        ];

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

        // Retrieve the correct duration, fallback to 30 days if a typo occurs
        $durationDays = $durations[$validated['plan_name']] ?? 30;

        // Calculate exact expiration date
        $endDate = Carbon::parse($validated['start_date'])->addDays($durationDays);

        // 3. Database Transaction (Save both or save nothing)
        DB::transaction(function () use ($validated, $durationDays, $endDate) {
            // A. Create the Member
            $member = Member::create([
                'member_code' => $validated['member_code'],
                'name'        => $validated['name'],
                'phone'       => $validated['phone'],
            ]);

            // B. Instantly Assign the Membership Plan (include payment amount)
            $member->memberships()->create([
                'plan_name'     => $validated['plan_name'],
                'duration_days' => $durationDays,
                'start_date'    => $validated['start_date'],
                'end_date'      => $endDate->toDateString(),
                'status'        => 'active',
                'payment_amount' => $prices[$validated['plan_name']] ?? null,
            ]);
        });

        // 4. Redirect straight to the directory to see the new member
        // Clear dashboard caches so revenue and expiring lists update immediately
        Cache::forget('dashboard.revenue_this_month');
        Cache::forget('dashboard.expiring_soon');
        return redirect()->route('members.index')->with('success', 'Member and Plan successfully added!');
    }
}
