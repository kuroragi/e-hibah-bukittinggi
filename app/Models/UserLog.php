<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLog extends Model
{
    protected $fillable = [
        'id_user',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the user that owns the UserLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function getRowClassAttribute()
    {
        return match ($this->action) {
            'create' => 'table-success',
            'update' => 'table-warning',
            'delete' => 'table-danger',
            default  => 'table-secondary',
        };
    }
}
