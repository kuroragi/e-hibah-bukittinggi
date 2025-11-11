<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lembaga extends BaseModel
{
    use HasFactory, SoftDeletes, Blameable;
    protected $fillable = [
        'name',
        'acronym',
        'id_skpd',
        'id_urusan',
        'email',
        'phone',
        'id_kelurahan',
        'alamat',
        'photo',
        'npwp',
        'no_akta_kumham',
        'date_akta_kumham',
        'file_akta_kumham',
        'no_domisili',
        'date_domisili',
        'file_domisili',
        'no_operasional',
        'date_operasional',
        'file_operasional',
        'no_pernyataan',
        'date_pernyataan',
        'file_pernyataan',
        'id_bank',
        'atas_nama',
        'no_rekening',
        'photo_rek',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'id_skpd');
    }

    public function urusan()
    {
        return $this->belongsTo(UrusanSkpd::class, 'id_urusan');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_lembaga');
    }

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class, 'id_lembaga');
    }

    public function nphdLembaga(): HasOne
    {
        return $this->hasOne(NphdLembaga::class, 'id_lembaga');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}
