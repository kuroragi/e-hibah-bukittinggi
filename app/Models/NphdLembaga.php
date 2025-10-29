<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NphdLembaga extends Model
{
    use SoftDeletes, Blameable;

    protected $fillable = [
        'id_lembaga',
        'nomor_pengukuhan',
        'tanggal_pengukuhan',
        'tentang_pengukuhan',
        'pemberi_amanat',
        'masa_bakti',
        'deskripsi',
        'uraian',
    ];

    /**
     * Get the lembaga that owns the NphdLembaga
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class, 'id_lembaga');
    }
}
