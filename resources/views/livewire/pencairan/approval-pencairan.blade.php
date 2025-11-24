<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Approval Pencairan</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pencairan') }}">Pencairan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Approval</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Approval Pencairan Dana Hibah</h5>
                </div>
                <div class="card-body">
                    <!-- Informasi Lembaga -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Informasi Lembaga</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Nama Lembaga:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->permohonan->lembaga->name }}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Ketua Lembaga:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->permohonan->lembaga->ketua ?? '-' }}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Email:</small>
                                    <p class="mb-2">{{ $pencairan->permohonan->lembaga->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">No. HP:</small>
                                    <p class="mb-2">{{ $pencairan->permohonan->lembaga->hp }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Rekening Bank:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->permohonan->lembaga->rekening ?? '-' }}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Nama Pemilik Rekening:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->permohonan->lembaga->name_rekening ?? '-' }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Permohonan -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Informasi Permohonan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <small class="text-muted">Perihal Permohonan:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->permohonan->perihal_mohon }}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Total Anggaran:</small>
                                    <p class="mb-2"><strong>Rp {{ number_format($pencairan->permohonan->jumlah_mohon, 0, ',', '.') }}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Tahun Anggaran:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->permohonan->tahun }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pencairan -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Detail Pencairan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">Tahap Pencairan:</small>
                                    <p class="mb-2">
                                        <span class="badge bg-info">Tahap {{ $pencairan->tahap_pencairan }}</span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Tanggal Pengajuan:</small>
                                    <p class="mb-2"><strong>{{ $pencairan->tanggal_pencairan->format('d M Y') }}</strong></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Status Saat Ini:</small>
                                    <p class="mb-2">
                                        <span class="badge bg-info">{{ ucfirst($pencairan->status) }}</span>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <small class="text-muted">Jumlah Pencairan:</small>
                                    <h4 class="text-primary mb-2">Rp {{ number_format($pencairan->jumlah_pencairan, 0, ',', '.') }}</h4>
                                </div>
                                @if($pencairan->keterangan)
                                    <div class="col-md-12">
                                        <small class="text-muted">Keterangan:</small>
                                        <p class="mb-0">{{ $pencairan->keterangan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Verifikasi -->
                    @if($pencairan->verified_at)
                        <div class="card mb-3 border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-check-circle"></i> Hasil Verifikasi</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Diverifikasi oleh:</small>
                                        <p class="mb-2"><strong>{{ $pencairan->verifier->name ?? '-' }}</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Tanggal Verifikasi:</small>
                                        <p class="mb-2"><strong>{{ $pencairan->verified_at->format('d M Y H:i') }}</strong></p>
                                    </div>
                                    @if($pencairan->catatan_verifikasi)
                                        <div class="col-md-12">
                                            <small class="text-muted">Catatan Verifikasi:</small>
                                            <p class="mb-0">{{ $pencairan->catatan_verifikasi }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Dokumen Pendukung -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Dokumen Pendukung</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @if($pencairan->file_lpj)
                                    <a href="{{ Storage::url($pencairan->file_lpj) }}" target="_blank" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-pdf text-danger"></i>
                                            <strong>Laporan Pertanggungjawaban (LPJ)</strong>
                                        </div>
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                                @if($pencairan->file_realisasi)
                                    <a href="{{ Storage::url($pencairan->file_realisasi) }}" target="_blank" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-pdf text-danger"></i>
                                            <strong>Laporan Realisasi Kegiatan</strong>
                                        </div>
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                                @if($pencairan->file_dokumentasi)
                                    <a href="{{ Storage::url($pencairan->file_dokumentasi) }}" target="_blank" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-earmark-zip text-info"></i>
                                            <strong>Dokumentasi Kegiatan</strong>
                                        </div>
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                                @if($pencairan->file_kwitansi)
                                    <a href="{{ Storage::url($pencairan->file_kwitansi) }}" target="_blank" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-pdf text-danger"></i>
                                            <strong>Kwitansi/Bukti Pengeluaran</strong>
                                        </div>
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Form Approval -->
                    <form wire:submit.prevent="approve">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Keputusan Approval</h6>
                            </div>
                            <div class="card-body">
                                <!-- Keputusan -->
                                <div class="mb-3">
                                    <label class="form-label">Keputusan Approval <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="keputusan" 
                                               value="disetujui" id="approval-setuju">
                                        <label class="form-check-label" for="approval-setuju">
                                            <strong class="text-success">Setujui & Proses Pencairan</strong>
                                            <br><small class="text-muted">Pencairan akan diproses oleh Bendahara</small>
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" wire:model="keputusan" 
                                               value="ditolak" id="approval-tolak">
                                        <label class="form-check-label" for="approval-tolak">
                                            <strong class="text-danger">Tolak Pencairan</strong>
                                            <br><small class="text-muted">Pengajuan ditolak dan dikembalikan</small>
                                        </label>
                                    </div>
                                    @error('keputusan')
                                        <div class="text-danger mt-1"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div class="mb-3">
                                    <label class="form-label">Catatan Approval <span class="text-danger">*</span></label>
                                    <textarea wire:model="catatan" rows="4" 
                                              class="form-control @error('catatan') is-invalid @enderror"
                                              placeholder="Tulis catatan keputusan approval..."></textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Berikan alasan yang jelas untuk keputusan Anda</small>
                                </div>

                                @if(session()->has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('pencairan') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" 
                                    wire:loading.attr="disabled"
                                    wire:target="approve">
                                <span wire:loading.remove wire:target="approve">
                                    <i class="bi bi-check2-all"></i> Simpan Approval
                                </span>
                                <span wire:loading wire:target="approve">
                                    <i class="bi bi-arrow-repeat spinner-border spinner-border-sm"></i> Processing...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Timeline Status -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Timeline Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Diajukan</h6>
                                <small>{{ $pencairan->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Diverifikasi</h6>
                                <small>{{ $pencairan->verified_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item active">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Disetujui</h6>
                                <small>Menunggu approval</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Dicairkan</h6>
                                <small>Proses pencairan dana</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pencairan Lembaga -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Riwayat Pencairan Lembaga</h6>
                </div>
                <div class="card-body">
                    @php
                        $riwayat = \App\Models\Pencairan::whereHas('permohonan', function($q) use ($pencairan) {
                            $q->where('lembaga_id', $pencairan->permohonan->lembaga_id);
                        })->where('id', '!=', $pencairan->id)
                        ->where('status', 'dicairkan')
                        ->latest()
                        ->take(5)
                        ->get();
                    @endphp
                    
                    @forelse($riwayat as $r)
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <small class="text-muted">{{ $r->tanggal_pencairan->format('d M Y') }}</small>
                                <p class="mb-0"><strong>Rp {{ number_format($r->jumlah_pencairan, 0, ',', '.') }}</strong></p>
                            </div>
                            <span class="badge bg-success">Dicairkan</span>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">Belum ada riwayat pencairan</p>
                    @endforelse
                </div>
            </div>

            <!-- Panduan Approval -->
            <div class="card mt-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Panduan Approval</h6>
                </div>
                <div class="card-body">
                    <ol class="mb-0" style="font-size: 0.9rem;">
                        <li>Periksa hasil verifikasi sebelumnya</li>
                        <li>Review seluruh dokumen pendukung</li>
                        <li>Validasi data rekening bank</li>
                        <li>Cek riwayat pencairan lembaga</li>
                        <li>Pastikan anggaran tersedia</li>
                        <li>Berikan keputusan yang objektif</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ddd;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        .timeline-marker {
            position: absolute;
            left: -26px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ddd;
            border: 3px solid #fff;
        }
        .timeline-item.active .timeline-marker {
            background: #0d6efd;
        }
        .timeline-item.completed .timeline-marker {
            background: #28a745;
        }
        .timeline-content h6 {
            margin-bottom: 2px;
            font-size: 0.9rem;
        }
        .timeline-content small {
            color: #6c757d;
            font-size: 0.8rem;
        }
    </style>
    @endpush
</div>
