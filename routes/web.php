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
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\NotificationController;



Route::get('/test-auth', function () {
    return auth()->check() ? 'Logged in as: ' . auth()->user()->id : 'Not authenticated';
});

Broadcast::routes(['middleware' => ['auth']]);


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
        Route::get('/monthly-hours', [DashboardController::class, 'getMonthlyHours']);

    });

    Route::group(['as' => 'notifications.', 'prefix' => '/notifications'], function () {
        Route::post('/mark-read/{id}', [NotificationController::class, 'markRead'])->name('markRead');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('markAllRead');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // Use the correct controller and method
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');



    Route::group(['as' => 'invoice.', 'prefix' => '/invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/download/{id}', [InvoiceController::class, 'download'])->name('download');
        Route::patch('/{payment}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('markAsPaid');
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
        Route::post('/{id}/submit', [TimesheetController::class, 'submit'])->name('submit');
        Route::post('/{id}/approve', [TimesheetController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [TimesheetController::class, 'reject'])->name('reject');
        // Route::get('/filter', [TimesheetController::class, 'filter'])->name('filter');
        // Route::get('/{timesheetDetailId}/total-actual-hours', [TimesheetController::class, 'getTotalActualHours']);
        Route::get('/{id}/total-hours', [TimesheetController::class, 'getTotalHours']);
        Route::post('/details/{id}/memo', [TimesheetDetailController::class, 'updateMemo'])->name('details.memo.update');
        Route::get('/export-all', [TimesheetController::class, 'exportAllToPdf'])->name('export.all');





    });

    // Route::post('/daily-task/store', [TaskController::class, 'storeDailyTask'])->name('daily-task.store');
    Route::prefix('timesheet/{timesheetDetailId}/tasks')->group(function () {
        Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/{taskId}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{taskId}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::get('/', [TaskController::class, 'getTasks'])->name('tasks.index');
        // Route::get('/timesheet/{id}/total-hours', [TaskController::class, 'getTotalHours']);

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
        Route::delete('/destroy/{id}', [ProjectController::class, 'destroy'])->name('destroy');
        Route::get('/view/{id}', [ProjectController::class, 'view'])->name('view');


    });




    // Route::middleware(['web'])->group(function () {
    //     // Route::post('/upload-file', [MediaController::class, 'uploadFile'])->name('upload.file');
    //     // Route::delete('/delete-file/{id}', [MediaController::class, 'deleteFile'])->name('delete.file');
    //     // Route::delete('/users/delete-file/{id}', [MediaController::class, 'deleteFile'])->name('delete.file');

    // });

});






