<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerbaikanRab extends Model
{
    use SoftDeletes, Blameable;

    protected $fillable = [
        'id_permohonan',
        'id_perbaikan',
        'revision_number',
        'nama_kegiatan',
        'subtotal',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get the permohonan that owns the PerbaikanRab
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    /**
     * Get all of the perbaikan_rincian for the PerbaikanRab
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function rincian(): HasMany
    // {
    //     return $this->hasMany(PerbaikanRincianRab::class, 'id_perbaikan_rab');
    // }
}
