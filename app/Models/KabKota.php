<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KabKota extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_propinsi',
        'name'
    ];

    /**
     * Get the propinsi that owns the KabKota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propinsi(): BelongsTo
    {
        return $this->belongsTo(Propinsi::class, 'id_propinsi');
    }

    /**
     * Get all of the kecamatan for the KabKota
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kecamatan(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'id_kabkota');
    }
}
