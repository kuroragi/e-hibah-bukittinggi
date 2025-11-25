@extends('components.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Detail Pencairan</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pencairan') }}">Pencairan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Status Badge -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Pencairan Tahap {{ $pencairan->tahap_pencairan }}</h5>
                            <p class="text-muted mb-0">{{ $pencairan->permohonan->perihal_mohon }}</p>
                        </div>
                        <div>
                            @php
                                $badgeClass = match ($pencairan->status) {
                                    'diajukan' => 'bg-warning',
                                    'diverifikasi' => 'bg-info',
                                    'disetujui' => 'bg-primary',
                                    'ditolak' => 'bg-danger',
                                    'dicairkan' => 'bg-success',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} fs-6">{{ ucfirst($pencairan->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Lembaga -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-building"></i> Informasi Lembaga</h6>
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
                            <small class="text-muted">Alamat:</small>
                            <p class="mb-2">{{ $pencairan->permohonan->lembaga->alamat ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">NPWP:</small>
                            <p class="mb-2">{{ $pencairan->permohonan->lembaga->npwp ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Permohonan -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-file-text"></i> Informasi Permohonan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-muted">Perihal Permohonan:</small>
                            <p class="mb-2"><strong>{{ $pencairan->permohonan->perihal_mohon }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Tahun Anggaran:</small>
                            <p class="mb-2"><strong>{{ $pencairan->permohonan->tahun }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Total Anggaran:</small>
                            <p class="mb-2"><strong>Rp
                                    {{ number_format($pencairan->permohonan->jumlah_mohon, 0, ',', '.') }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">No. Permohonan:</small>
                            <p class="mb-2">{{ $pencairan->permohonan->no_mohon }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pencairan -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-cash-stack"></i> Detail Pencairan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted">Tahap Pencairan:</small>
                            <p class="mb-2">
                                <span class="badge bg-info fs-6">Tahap {{ $pencairan->tahap_pencairan }}</span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Tanggal Pengajuan:</small>
                            <p class="mb-2"><strong>{{ $pencairan->tanggal_pencairan->format('d F Y') }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Tanggal Dibuat:</small>
                            <p class="mb-2">{{ $pencairan->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-md-12 mt-2">
                            <small class="text-muted">Jumlah Pencairan:</small>
                            <h3 class="text-primary mb-2">Rp {{ number_format($pencairan->jumlah_pencairan, 0, ',', '.') }}
                            </h3>
                        </div>
                        @if ($pencairan->keterangan)
                            <div class="col-md-12">
                                <small class="text-muted">Keterangan:</small>
                                <p class="mb-0">{{ $pencairan->keterangan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Rekening -->
            @if ($pencairan->status == 'disetujui' || $pencairan->status == 'dicairkan')
                <div class="card mb-3 border-primary">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-bank"></i> Informasi Rekening Penerima</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Nama Bank:</small>
                                <p class="mb-2"><strong>{{ $pencairan->permohonan->lembaga->bank->name ?? '-' }}</strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">No. Rekening:</small>
                                <p class="mb-2"><strong>{{ $pencairan->permohonan->lembaga->rekening ?? '-' }}</strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Atas Nama:</small>
                                <p class="mb-2">
                                    <strong>{{ $pencairan->permohonan->lembaga->name_rekening ?? '-' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Dokumen Pendukung -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-paperclip"></i> Dokumen Pendukung</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @if ($pencairan->file_lpj)
                            <a href="{{ Storage::url($pencairan->file_lpj) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-pdf text-danger fs-4"></i>
                                    <strong class="ms-2">Laporan Pertanggungjawaban (LPJ)</strong>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="bi bi-download"></i> Download
                                </span>
                            </a>
                        @endif
                        @if ($pencairan->file_realisasi)
                            <a href="{{ Storage::url($pencairan->file_realisasi) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-pdf text-danger fs-4"></i>
                                    <strong class="ms-2">Laporan Realisasi Kegiatan</strong>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="bi bi-download"></i> Download
                                </span>
                            </a>
                        @endif
                        @if ($pencairan->file_dokumentasi)
                            <a href="{{ Storage::url($pencairan->file_dokumentasi) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-earmark-zip text-info fs-4"></i>
                                    <strong class="ms-2">Dokumentasi Kegiatan</strong>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="bi bi-download"></i> Download
                                </span>
                            </a>
                        @endif
                        @if ($pencairan->file_kwitansi)
                            <a href="{{ Storage::url($pencairan->file_kwitansi) }}" target="_blank"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-pdf text-danger fs-4"></i>
                                    <strong class="ms-2">Kwitansi/Bukti Pengeluaran</strong>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    <i class="bi bi-download"></i> Download
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hasil Verifikasi -->
            @if ($pencairan->verified_at)
                <div class="card mb-3 {{ $pencairan->status == 'ditolak' ? 'border-danger' : 'border-success' }}">
                    <div
                        class="card-header {{ $pencairan->status == 'ditolak' ? 'bg-danger' : 'bg-success' }} text-white">
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
                                <p class="mb-2"><strong>{{ $pencairan->verified_at->format('d F Y H:i') }}</strong></p>
                            </div>
                            @if ($pencairan->catatan_verifikasi)
                                <div class="col-md-12">
                                    <small class="text-muted">Catatan Verifikasi:</small>
                                    <div class="alert alert-light mt-2">
                                        {{ $pencairan->catatan_verifikasi }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hasil Approval -->
            @if ($pencairan->approved_at)
                <div class="card mb-3 {{ $pencairan->status == 'ditolak' ? 'border-danger' : 'border-primary' }}">
                    <div
                        class="card-header {{ $pencairan->status == 'ditolak' ? 'bg-danger' : 'bg-primary' }} text-white">
                        <h6 class="mb-0"><i class="bi bi-check2-all"></i> Hasil Approval</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Disetujui oleh:</small>
                                <p class="mb-2"><strong>{{ $pencairan->approver->name ?? '-' }}</strong></p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Tanggal Approval:</small>
                                <p class="mb-2"><strong>{{ $pencairan->approved_at->format('d F Y H:i') }}</strong></p>
                            </div>
                            @if ($pencairan->catatan_approval)
                                <div class="col-md-12">
                                    <small class="text-muted">Catatan Approval:</small>
                                    <div class="alert alert-light mt-2">
                                        {{ $pencairan->catatan_approval }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('pencairan') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pencairan
                </a>
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
                        <div
                            class="timeline-item {{ in_array($pencairan->status, ['diverifikasi', 'disetujui', 'dicairkan']) ? 'completed' : ($pencairan->status == 'ditolak' && $pencairan->verified_at ? 'rejected' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Diverifikasi</h6>
                                <small>
                                    @if ($pencairan->verified_at)
                                        {{ $pencairan->verified_at->format('d M Y H:i') }}
                                    @else
                                        Menunggu verifikasi
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div
                            class="timeline-item {{ in_array($pencairan->status, ['disetujui', 'dicairkan']) ? 'completed' : ($pencairan->status == 'ditolak' && $pencairan->approved_at ? 'rejected' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Disetujui</h6>
                                <small>
                                    @if ($pencairan->approved_at)
                                        {{ $pencairan->approved_at->format('d M Y H:i') }}
                                    @else
                                        Menunggu approval
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="timeline-item {{ $pencairan->status == 'dicairkan' ? 'completed' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Dicairkan</h6>
                                <small>
                                    @if ($pencairan->status == 'dicairkan')
                                        Dana telah dicairkan
                                    @else
                                        Menunggu pencairan
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pencairan -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Riwayat Pencairan Permohonan</h6>
                </div>
                <div class="card-body">
                    @forelse($pencairan->permohonan->pencairans()->orderBy('tahap_pencairan')->get() as $p)
                        <div
                            class="d-flex align-items-center mb-3 pb-3 border-bottom {{ $p->id == $pencairan->id ? 'bg-light p-2 rounded' : '' }}">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-1">Tahap {{ $p->tahap_pencairan }}</h6>
                                    @if ($p->id == $pencairan->id)
                                        <span class="badge bg-info ms-2">Current</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $p->tanggal_pencairan->format('d M Y') }}</small>
                                <p class="mb-0 mt-1">
                                    <strong>Rp {{ number_format($p->jumlah_pencairan, 0, ',', '.') }}</strong>
                                </p>
                            </div>
                            <div>
                                @php
                                    $badgeClass = match ($p->status) {
                                        'diajukan' => 'bg-warning',
                                        'diverifikasi' => 'bg-info',
                                        'disetujui' => 'bg-primary',
                                        'ditolak' => 'bg-danger',
                                        'dicairkan' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($p->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">Tidak ada riwayat</p>
                    @endforelse
                </div>
            </div>

            <!-- Summary Keuangan -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Summary Keuangan</h6>
                </div>
                <div class="card-body">
                    @php
                        $totalDicairkan = $pencairan->permohonan
                            ->pencairans()
                            ->where('status', 'dicairkan')
                            ->sum('jumlah_pencairan');
                        $totalDisetujui = $pencairan->permohonan
                            ->pencairans()
                            ->where('status', 'disetujui')
                            ->sum('jumlah_pencairan');
                        $sisaDana = $pencairan->permohonan->jumlah_mohon - $totalDicairkan - $totalDisetujui;
                    @endphp

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Total Anggaran:</small>
                            <strong>Rp {{ number_format($pencairan->permohonan->jumlah_mohon, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Sudah Dicairkan:</small>
                            <strong class="text-success">Rp {{ number_format($totalDicairkan, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Disetujui (Proses):</small>
                            <strong class="text-primary">Rp {{ number_format($totalDisetujui, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="d-flex justify-content-between">
                            <strong>Sisa Dana:</strong>
                            <strong class="text-danger">Rp {{ number_format($sisaDana, 0, ',', '.') }}</strong>
                        </div>
                    </div>
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

            .timeline-item.completed .timeline-marker {
                background: #28a745;
            }

            .timeline-item.rejected .timeline-marker {
                background: #dc3545;
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
@endsection
