<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkpdDetail extends Model
{
    use SoftDeletes, Blameable;

    protected $fillable = [
        'id_skpd',
        'nama_pimpinan',
        'jabatan',
        'alamat_pimpinan',
        'hp_pimpinan',
        'email_pimpinan',
        'perhatian_nphd',
        'rekening_anggaran',
    ];

    /**
     * Get the config that owns the NphdFieldConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function config(): BelongsTo
    {
        return $this->belongsTo(Skpd::class, 'id_config');
    }
}
