<?php

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('generates a SK-prefixed member_code on create', function () {
    $member = Member::create([
        'name' => 'Test Member',
        'phone' => '9990001111',
    ]);

    expect($member->member_code)->toBeString()->toMatch('/^SK\d{6}\d{4}$/');
});
