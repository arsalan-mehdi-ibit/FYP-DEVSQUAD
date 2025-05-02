<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifications;

class NotificationController extends Controller
{
    // Mark a single notification as read
    public function markRead($id)
    {
        $notification = Notifications::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification && $notification->is_read == 0) {
            $notification->update(['is_read' => 1]);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'already_read_or_not_found']);
    }

    // Mark all notifications as read
    public function markAllRead()
    {
        Notifications::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['status' => 'success']);
    }
}
