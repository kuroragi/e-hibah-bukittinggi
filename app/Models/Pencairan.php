<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pencairan extends Model
{
    use Blameable;

    protected $fillable = [
        'id_permohonan',
        'tanggal_pencairan',
        'jumlah_pencairan',
        'tahap_pencairan',
        'status',
        'bukti',
        'keterangan',
        'file_lpj',
        'file_realisasi',
        'file_dokumentasi',
        'file_kwitansi',
        'verified_by',
        'verified_at',
        'catatan_verifikasi',
        'approved_by',
        'approved_at',
        'catatan_approval',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'tanggal_pencairan' => 'date',
    ];

    /**
     * Get the permohonan that owns the Pencairan
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    /**
     * Get the user who verified the pencairan
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the user who approved the pencairan
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by tahap
     */
    public function scopeTahap($query, $tahap)
    {
        return $query->where('tahap_pencairan', $tahap);
    }

    /**
     * Check if pencairan is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'disetujui' || $this->status === 'dicairkan';
    }

    /**
     * Check if pencairan is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'dicairkan';
    }
}
