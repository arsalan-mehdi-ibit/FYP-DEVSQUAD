<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;

function push_notification(string $message, int $userId): void
{
    event(new NewNotification($message, $userId));
}
