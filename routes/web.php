<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total_members' => Member::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'inactive_members' => Member::where('status', 'inactive')->count(),
            'new_this_month' => Member::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $expiringSoon = Cache::remember('dashboard.expiring_soon', 300, function () {
            return Membership::where('status', 'active')
                ->whereBetween('end_date', [now(), now()->addDays(7)])
                ->with('member')
                ->orderBy('end_date')
                ->get()
                ->map(function ($m) {
                    return [
                        'id' => $m->id,
                        'member_id' => $m->member_id,
                        'end_date' => optional($m->end_date)->toDateString(),
                        'member' => [
                            'id' => $m->member->id ?? null,
                            'name' => $m->member->name ?? null,
                            'member_code' => $m->member->member_code ?? null,
                        ],
                    ];
                })->toArray();
        });

        // Revenue metrics (by membership start_date)
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

        $revenueAllTime = Cache::remember('dashboard.revenue_all_time', 300, function () use ($prices) {
            $items = Membership::select('plan_name', 'payment_amount')->get();
            return (float) $items->reduce(function ($carry, $m) use ($prices) {
                $amt = $m->payment_amount ?? ($prices[$m->plan_name] ?? 0);
                return $carry + (float) $amt;
            }, 0);
        });

        $revenueThisMonth = Cache::remember('dashboard.revenue_this_month', 300, function () use ($prices) {
            $items = Membership::select('plan_name', 'payment_amount', 'start_date')
                ->whereBetween('start_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
                ->get();
            return (float) $items->reduce(function ($carry, $m) use ($prices) {
                $amt = $m->payment_amount ?? ($prices[$m->plan_name] ?? 0);
                return $carry + (float) $amt;
            }, 0);
        });

        $revenueLast3Months = Cache::remember('dashboard.revenue_last_3_months', 300, function () use ($prices) {
            $items = Membership::select('plan_name', 'payment_amount', 'start_date')
                ->whereBetween('start_date', [now()->subMonths(3)->startOfDay()->toDateString(), now()->endOfDay()->toDateString()])
                ->get();
            return (float) $items->reduce(function ($carry, $m) use ($prices) {
                $amt = $m->payment_amount ?? ($prices[$m->plan_name] ?? 0);
                return $carry + (float) $amt;
            }, 0);
        });

        $revenueLast6Months = Cache::remember('dashboard.revenue_last_6_months', 300, function () use ($prices) {
            $items = Membership::select('plan_name', 'payment_amount', 'start_date')
                ->whereBetween('start_date', [now()->subMonths(6)->startOfDay()->toDateString(), now()->endOfDay()->toDateString()])
                ->get();
            return (float) $items->reduce(function ($carry, $m) use ($prices) {
                $amt = $m->payment_amount ?? ($prices[$m->plan_name] ?? 0);
                return $carry + (float) $amt;
            }, 0);
        });

        $stats['revenue_all_time'] = $revenueAllTime;
        $stats['revenue_this_month'] = $revenueThisMonth;
        $stats['revenue_last_3_months'] = $revenueLast3Months;
        $stats['revenue_last_6_months'] = $revenueLast6Months;

        return view('dashboard', compact('stats', 'expiringSoon'));
    })->name('dashboard');

    Route::resource('members', MemberController::class);
    // Memberships routes
    Route::get('members/{member}/memberships/create', [MembershipController::class, 'create'])->name('memberships.create');
    Route::post('members/{member}/memberships', [MembershipController::class, 'store'])->name('memberships.store');
});

require __DIR__.'/settings.php';
