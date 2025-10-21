<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NphdFieldConfig extends Model
{
    use SoftDeletes, Blameable;

    protected $fillable = [
        'id_config',
        'label',
        'name',
        'type',
        'options',
        'is_required',
        'order',
    ];

    /**
     * Get the config that owns the NphdFieldConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function config(): BelongsTo
    {
        return $this->belongsTo(NphdConfig::class, 'id_config');
    }
}
