<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Use the correct controller
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\TimesheetDetailController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProfileController;

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset'); // This route displays the form (GET request)

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store'); // This route handles the form submission (POST request)

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

    Route::group(['as' => 'dashboard.', 'prefix' => '/dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // Use the correct controller and method

    Route::group(['as' => 'invoice.', 'prefix' => '/invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
    });

    Route::group(['as' => 'users.', 'prefix' => '/users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/add', [UsersController::class, 'add'])->name('add');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
    });
    

    Route::group(['as' => 'timesheet.', 'prefix' => '/timesheet'], function () {
        Route::get('/', [TimesheetController::class, 'index'])->name('index');
        Route::get('/details', [TimesheetDetailController::class, 'index'])->name('details.index');
        Route::get('/details/{id}', [TimesheetDetailController::class, 'show'])->name('details.detail');
    });
    

    Route::group(['as' => 'project.', 'prefix' => '/project'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
    });
   
});






