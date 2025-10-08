<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RabPermohonan extends Model
{
    use SoftDeletes, Blameable;

    protected $fillable = [
        'id_permohonan',
        'nama_kegiatan'
    ];

    /**
     * Get the permohonan that owns the RabPermohonan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    /** Rincian dihapuskan */
}
