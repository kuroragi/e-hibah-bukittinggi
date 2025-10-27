<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrusanSkpd extends BaseModel
{
    use SoftDeletes, Blameable;
    protected $fillable = [
        'id_skpd',
        'nama_urusan',
        'kepala_urusan',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function skpd()
    {
        return $this->belongsTo(SKPD::class, 'id_skpd');
    }
}
