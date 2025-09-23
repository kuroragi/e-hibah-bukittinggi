<?php

namespace App\Services;

use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class UserLogService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        string $action,
        ?string $description = null
    ) {
        UserLog::create([
            'id_user'    => Auth::user()->id,
            'action'     => $action,
            'description'=> $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
