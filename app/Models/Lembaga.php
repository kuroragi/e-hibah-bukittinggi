<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lembaga extends BaseModel
{
    use SoftDeletes, Blameable;
    protected $fillable = [
        'name',
        'id_skpd',
        'id_urusan',
        'email',
        'phone',
        'id_kelurahan',
        'alamat',
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
}
