<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengurus extends Model
{
    use SoftDeletes, Blameable;
    protected $fillable = [
        'id_lembaga',
        'name',
        'jabatan',
        'nik',
        'no_hp',
        'email',
        'alamat',
        'scan_ktp',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class, 'id_lembaga');
    }
}
