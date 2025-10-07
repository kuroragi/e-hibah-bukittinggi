<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogService
{

    public static function log(string $event, string $level = 'info', $description, $data = '{}'): void
    {
        $user = Auth::user();

        $log = [
            'timestamp' => now()->toDateTimeString(),
            'event'     => $event,
            'level'     => $level,
            'user'      =>  [
                'id'    => $user->id ?? null,
                'name'  => $user->name ?? $user->username ?? null,
                'role' => $user->roles->pluck('name')[0] ?? null,
            ],
            'context'   => ['description' => $description, 'data' => $data],
            'meta'      => [
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ],
        ];


        Log::channel('activity')->info(json_encode($log));
    }
}
