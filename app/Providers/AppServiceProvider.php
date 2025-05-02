<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\FileAttachment;
use Illuminate\Pagination\Paginator;
use App\Models\Notifications;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }



    public function boot(): void
    {
        // Enable Tailwind pagination
        Paginator::useTailwind();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Profile picture logic
                $profilePicture = FileAttachment::where('parent_id', $user->id)
                    ->where('file_for', 'profile')
                    ->latest()
                    ->first();

                $profilePicPath = $profilePicture ? asset($profilePicture->file_path) : asset('assets/profile.jpeg');

                // Notifications logic
                $notifications = Notifications::where('user_id', $user->id)->latest()->limit(10)->get();
                $unreadCount = $notifications->where('is_read', 0)->count();

                // Share with all views
                $view->with([
                    'headerProfilePic' => $profilePicPath,
                    'notifications' => $notifications,
                    'unreadNotificationCount' => $unreadCount,
                ]);
            } else {
                $view->with('headerProfilePic', asset('assets/profile.jpeg'));
            }
        });
    }


}
