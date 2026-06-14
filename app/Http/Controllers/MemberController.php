<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'member_code' => ['required', 'string', 'max:255', 'unique:members,member_code'],
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:20', 'unique:members,phone'],
            'email'       => ['nullable', 'email', 'max:255', 'unique:members,email'],
        ]);

        // Save the validated data into the database
        Member::create($validatedData);

        // Redirect back with a success message
        return back()->with('success', 'Gym Member added successfully!');
    }
}
