<?php

namespace App\Services;

use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class UserLogService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function log(string $action, ?string $description = null): void {
        UserLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'description'=> $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
