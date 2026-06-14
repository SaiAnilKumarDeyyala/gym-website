<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('blocks overlapping scheduled memberships for the same member via the memberships.store route', function () {
    // Create an admin user and a member
    $user = User::factory()->create();
    $this->actingAs($user);

    $member = Member::create([
        'name' => 'Overlap Tester',
        'phone' => '8887776666',
    ]);

    $start1 = now()->addDays(30)->toDateString();
    $start2 = now()->addDays(40)->toDateString();

    // First scheduled membership should be accepted
    $response1 = $this->post(route('memberships.store', $member), [
        'plan_name' => '1 Month Strength',
        'duration_days' => 30,
        'start_date' => $start1,
        'payment_amount' => 1399,
    ]);

    $response1->assertSessionHas('success');

    // Second scheduled membership overlapping should be blocked
    $response2 = $this->post(route('memberships.store', $member), [
        'plan_name' => '1 Month Strength',
        'duration_days' => 30,
        'start_date' => $start2, // overlaps with first (start1 + 30 days)
        'payment_amount' => 1399,
    ]);

    $response2->assertSessionHas('error');
});
