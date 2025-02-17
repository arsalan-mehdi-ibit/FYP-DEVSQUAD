<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Show the login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Handle the login attempt
Route::post('/login', [LoginController::class, 'login']);

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/profile', function () {
        return view('profile');
    });
});
