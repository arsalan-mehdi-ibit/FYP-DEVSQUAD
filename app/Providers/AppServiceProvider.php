<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\FileAttachment;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         // Enable Tailwind pagination
         Paginator::useTailwind();
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $profilePicture = FileAttachment::where('parent_id', $user->id)
                    ->where('file_for', 'profile')
                    ->latest()
                    ->first();

                $view->with(
                    'headerProfilePic',
                    $profilePicture ? asset($profilePicture->file_path) : asset('assets/profile.jpeg')
                );
            } else {
                $view->with('headerProfilePic', asset('assets/profile.jpeg'));
            }
        });
    }

}
