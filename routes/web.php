<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Use the correct controller
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Show the login form
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login'); // Use the correct controller and method
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login'); // Use the correct controller and method

// Handle the login attempt
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // Use the correct controller and method

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout'); // Use the correct controller and method

// Protected routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/profile', function () {
        return view('profile');
    });

    Route::group(['as' => 'invoice.', 'prefix' => '/invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
    });

    Route::group(['as' => 'users.', 'prefix' => '/users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
    });

    Route::group(['as' => 'timesheet.', 'prefix' => '/timesheet'], function () {
        Route::get('/', [TimesheetController::class, 'index'])->name('index');
    });

    Route::group(['as' => 'project.', 'prefix' => '/project'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
    });
    
});
