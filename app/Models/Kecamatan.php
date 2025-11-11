<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kabkota',
        'name'
    ];

    /**
     * Get the kabkota that owns the Kecamatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kabkota(): BelongsTo
    {
        return $this->belongsTo(KabKota::class, 'id_kabkota');
    }

    /**
     * Get all of the kelurahan for the Kecamatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelurahan(): HasMany
    {
        return $this->hasMany(Kelurahan::class, 'id_kecamatan');
    }
}
