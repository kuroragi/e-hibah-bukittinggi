<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_button',
        'action_buttons',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\StatusPermohonanFactory::new();
    }
}
