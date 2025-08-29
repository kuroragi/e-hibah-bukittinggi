<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permohonan extends Model
{
    use SoftDeletes, Blameable;
    protected $fillable = [
        'id_lembaga',
        'no_mohon',
        'tanggal_mohon',
        'tahun_apbd',
        'perihal_mohon',
        'file_mohon',
        'no_proposal',
        'tanggal_proposal',
        'title',
        'urusan',
        'id_skpd',
        'awal_laksana',
        'akhir_laksana',
        'latar_belakang',
        'maksud_tujuan',
        'keterangan',
        'file_proposal',
        'nominal_rab',
        'nominal_anggaran',
        'id_status',
        'status_rekomendasi',
        'nominal_rekomendasi',
        'tanggal_rekomendasi',
        'catatan_rekomendasi',
        'file_pemberitahuan',
        'file_permintaan_nphd',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function lembaga(){
        return $this->belongsTo(Lembaga::class, 'id_lembaga');
    }

    public function skpd(){
        return $this->belongsTo(Skpd::class, 'id_skpd');
    }

    public function urusan_skpd(){
        return $this->belongsTo(UrusanSkpd::class, 'urusan');
    }

    public function status(){
        return $this->belongsTo(Status_permohonan::class, 'id_status');
    }

    public function pendukung(){
        return $this->hasOne(PendukungPermohonan::class, 'id_permohonan');
    }

    public function perbaikanProposal(){
        return $this->hasMany(perbaikanProposal::class, 'id_permohonan');
    }

    public function perbaikanRab(){
        return $this->hasMany(PerbaikanRab::class, 'id_permohonan');
    }
}
