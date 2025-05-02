<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    \Log::info('Broadcast auth attempt', ['user_id' => $user->id, 'channel_user' => $userId]);
    return (int) $user->id === (int) $userId;
});
