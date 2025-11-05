<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class Skpd extends BaseModel
{
    use SoftDeletes, Blameable;
    
    protected $fillable = [
        'type',
        'name',
        'deskripsi',
        'alamat',
        'telp',
        'email',
        'fax',
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(SkpdDetail::class, 'id_skpd');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_skpd');
    }

    public function lembagas()
    {
        return $this->hasMany(Lembaga::class, 'id_skpd');
    }

    public function has_urusan()
    {
        return $this->hasMany(UrusanSkpd::class, 'id_skpd');
    }
}
