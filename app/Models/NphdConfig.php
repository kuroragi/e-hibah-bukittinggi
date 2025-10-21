<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NphdConfig extends Model
{
    use SoftDeletes, Blameable;

    protected $fillable = [
        'nama_klausul',
        'deskripsi',
        'id_skpd',
        'id_lembaga',
    ];

    /**
     * Get all of the field for the NphdConfig
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function field(): HasMany
    {
        return $this->hasMany(NphdFieldConfig::class, 'id_config');
    }
}
