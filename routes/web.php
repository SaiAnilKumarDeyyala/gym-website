<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('members', MemberController::class);
});

require __DIR__.'/settings.php';
