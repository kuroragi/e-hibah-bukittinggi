<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nphd extends Model
{
    use Blameable;

    protected $fillable = [
        'id_permohonan',
        'file_nphd',
        'no_nphd',
        'tanggal_nphd',
        'nilai_disetujui',
        'is_Signed_pemprov',
        'is_Signed_pemko',
        'no_permohonan',
        'tanggal_permohonan',
        'file_permohonan',
    ];

    /**
     * Get the permohonan that owns the Nphd
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(permohonan::class, 'id_permohonan');
    }
}
