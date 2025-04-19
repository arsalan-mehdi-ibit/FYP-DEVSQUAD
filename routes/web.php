<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
use App\Http\Controllers\MediaController;


Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset'); // This route displays the form (GET request)

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store'); // This route handles the form submission (POST request)

// Forgot Password
Route::get('/forgot-password', [NewPasswordController::class, 'showForgotForm'])->name('password.request');

Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword'])
    ->name('password.email');


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
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');



    Route::group(['as' => 'invoice.', 'prefix' => '/invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
    });

    Route::group(['as' => 'users.', 'prefix' => '/users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/add', [UsersController::class, 'add'])->name('add');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UsersController::class, 'editUser'])->name('edit');
        Route::put('/update/{id}', [UsersController::class, 'update'])->name('update');
        Route::delete('/delete-file/{id}', [MediaController::class, 'deleteFile'])->name('delete.file');
        Route::get('/download-file/{id}', [MediaController::class, 'downloadFile'])->name('downloadFile');
        Route::delete('/destroy/{id}', [UsersController::class, 'destroy'])->name('destroy');


    });


    Route::group(['as' => 'timesheet.', 'prefix' => '/timesheet'], function () {
        Route::get('/', [TimesheetController::class, 'index'])->name('index');
        Route::get('/details', [TimesheetDetailController::class, 'index'])->name('details.index');
        Route::get('/details/{id}', [TimesheetDetailController::class, 'show'])->name('details.detail');
    });


    Route::group(['as' => 'project.', 'prefix' => '/project'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/add', [ProjectController::class, 'add'])->name('add');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/delete-file/{id}', [MediaController::class, 'deleteFile'])->name('delete.file');
        Route::get('/download-file/{id}', [MediaController::class, 'downloadFile'])->name('downloadFile');
        Route::delete('/remove-contractor/{contractorId}', [ProjectController::class, 'removeContractor'])->name('removeContractor');

    });
    


    // Route::middleware(['web'])->group(function () {
    //     // Route::post('/upload-file', [MediaController::class, 'uploadFile'])->name('upload.file');
    //     // Route::delete('/delete-file/{id}', [MediaController::class, 'deleteFile'])->name('delete.file');
    //     // Route::delete('/users/delete-file/{id}', [MediaController::class, 'deleteFile'])->name('delete.file');

    // });

});






