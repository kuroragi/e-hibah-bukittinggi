<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelurahan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kecamatan',
        'name'
    ];

    /**
     * Get the kecamatan that owns the Kelurahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
    
    /**
     * Get all of the lembaga for the Kelurahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lembaga(): HasMany
    {
        return $this->hasMany(Lembaga::class, 'id_kelurahan');
    }
}
