<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Propinsi extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the kabkota for the Propinsi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kabkota(): HasMany
    {
        return $this->hasMany(kabkota::class, 'id_propinsi');
    }
}
