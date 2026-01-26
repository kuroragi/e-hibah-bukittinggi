@extends('components.layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboards</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100 bg-gradient"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-header border-0">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h4 class="mb-1 text-white"><i class="bi bi-emoji-smile"></i> Selamat Datang, <span
                                    class="fw-bold">{{ ucwords(auth()->user()->name) }}</span></h4>
                            <p class="mb-0 text-white-50"><i class="bi bi-shield-check"></i>
                                {{ auth()->user()->getRoleNames()->first() ?? 'User' }} | <i
                                    class="bi bi-calendar-event"></i> {{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                        <div class="col-auto">
                            @if (auth()->user()->lembaga)
                                <div class="text-white text-end">
                                    <small class="d-block text-white-50">Lembaga</small>
                                    <strong>{{ auth()->user()->lembaga->nama_lembaga ?? '-' }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            @if (auth()->user()->hasRole('Super Admin'))
                <div class="col">
                    <div class="card radius-10 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-1 text-secondary"><i class="bi bi-people-fill"></i> Total Pengguna</p>
                                    <h4 class="mb-0 text-primary fw-bold">{{ $user->count() }}</h4>
                                    <small class="text-muted">Pengguna Terdaftar</small>
                                </div>
                                <div class="ms-auto">
                                    <div class="widget-icon bg-primary text-white rounded-circle"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-1 text-secondary"><i class="bi bi-building"></i> Total Lembaga</p>
                                    <h4 class="mb-0 text-success fw-bold">{{ $lembaga->count() }}</h4>
                                    <small class="text-muted">Lembaga Aktif</small>
                                </div>
                                <div class="ms-auto">
                                    <div class="widget-icon bg-success text-white rounded-circle"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-buildings fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasRole('Admin Lembaga'))
                <div class="col">
                    <div class="card radius-10 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-1 text-secondary"><i class="bi bi-file-earmark-text"></i> Permohonan Saya
                                    </p>
                                    <h4 class="mb-0 text-info fw-bold">
                                        {{ $permohonan->where('id_lembaga', auth()->user()->id_lembaga)->count() }}</h4>
                                    <small class="text-muted">Total Diajukan</small>
                                </div>
                                <div class="ms-auto">
                                    <div class="widget-icon bg-info text-white rounded-circle"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-files fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col">
                <div class="card radius-10 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-secondary"><i class="bi bi-check-circle"></i> Hibah Dicairkan</p>
                                <h4 class="mb-0 text-success fw-bold">{{ $permohonan->where('id_status', 14)->count() }}
                                </h4>
                                <small class="text-muted">Permohonan Selesai</small>
                            </div>
                            <div class="ms-auto">
                                <div class="widget-icon bg-success text-white rounded-circle"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-patch-check fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-secondary"><i class="bi bi-cash-coin"></i> Total Dana Hibah</p>
                                <h5 class="mb-0 text-warning fw-bold">Rp
                                    {{ number_format($permohonan->sum('nominal_anggaran') / 1000000, 1) }}M</h5>
                                <small class="text-muted">Tahun {{ date('Y') }}</small>
                            </div>
                            <div class="ms-auto">
                                <div class="widget-icon bg-warning text-white rounded-circle"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-wallet2 fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->



        <div class="row my-4">

            <div class="col-12 col-lg-12 col-xl-6 d-flex">
                <div class="card radius-10 w-100 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 text-dark"><i class="bi bi-graph-up"></i> Status Permohonan Hibah</h6>
                        <small class="text-muted">Ringkasan berdasarkan tahapan proses</small>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-3 row-cols-xxl-3 g-3">
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none">
                                    <div class="card-body text-center">
                                        <div class="widget-icon mx-auto mb-3 bg-success text-white">
                                            <i class="bi bi-file-fill"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $permohonan->count() }}</h3>
                                        <p class="mb-0">Permohonan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none">
                                    <div class="card-body text-center">
                                        <div class="widget-icon mx-auto mb-3 bg-tiffany text-white">
                                            <i class="bi bi-file-earmark-break-fill"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $permohonan->whereBetween('id_status', [1, 3])->count() }}
                                        </h3>
                                        <p class="mb-0">Draft</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none">
                                    <div class="card-body text-center">
                                        <div class="widget-icon mx-auto mb-3 bg-pink text-white">
                                            <i class="bi bi-search"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $permohonan->whereBetween('id_status', [4, 6])->count() }}
                                        </h3>
                                        <p class="mb-0">Diperiksa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none">
                                    <div class="card-body text-center">
                                        <div class="widget-icon mx-auto mb-3 bg-info text-white">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $permohonan->where('id_status', 7)->count() }}</h3>
                                        <p class="mb-0">Direkomendasi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none">
                                    <div class="card-body text-center">
                                        <div class="widget-icon mx-auto mb-3 bg-warning text-dark">
                                            <i class="bi bi-exclamation-square-fill"></i>
                                        </div>
                                        <h3 class="mb-0">
                                            {{ $permohonan->whereIn('id_status', [8, 10, 11, 12, 13])->count() }}
                                        </h3>
                                        <p class="mb-0">Dikoreksi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none">
                                    <div class="card-body text-center">
                                        <div class="widget-icon mx-auto mb-3 bg-danger text-white">
                                            <i class="bi bi-x-lg"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $permohonan->where('id_status', 9)->count() }}</h3>
                                        <p class="mb-0">Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6 d-flex">
                <div class="card radius-10 w-100 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h6 class="mb-0 text-dark"><i class="bi bi-graph-up-arrow"></i> Trend Pencairan Dana</h6>
                                <small class="text-muted">Dalam Juta Rupiah - Tahun {{ date('Y') }}</small>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-success">{{ $pencairan->sum() / 1000 }}M Total</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pencairan Dana Hibah Statistics -->
        <div class="row my-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0"><i class="bi bi-bar-chart-fill text-primary"></i> Statistik Pencairan Dana
                            Hibah</h5>
                        <small class="text-muted">Ringkasan status dan realisasi pencairan</small>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border"><i class="bi bi-calendar3"></i> Tahun
                            {{ date('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            <div class="col">
                <div class="card radius-10 border-0 shadow-sm" style="border-left: 4px solid #0dcaf0 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-secondary fw-semibold"><i class="bi bi-list-check"></i> Total
                                    Pencairan</p>
                                <h4 class="mb-0 text-info fw-bold">{{ $pencairanStats['total'] }}</h4>
                                <small class="text-muted">Pengajuan Pencairan</small>
                            </div>
                            <div class="ms-auto">
                                <div class="widget-icon bg-info bg-opacity-10 text-info rounded-circle"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-cash-stack fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-0 shadow-sm" style="border-left: 4px solid #198754 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-secondary fw-semibold"><i class="bi bi-currency-dollar"></i> Dana
                                    Dicairkan</p>
                                <h6 class="mb-0 text-success fw-bold">Rp
                                    {{ number_format($pencairanStats['totalDana'], 0, ',', '.') }}</h6>
                                <small class="text-muted">Realisasi Dana</small>
                            </div>
                            <div class="ms-auto">
                                <div class="widget-icon bg-success bg-opacity-10 text-success rounded-circle"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-check-circle fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-0 shadow-sm" style="border-left: 4px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-secondary fw-semibold"><i class="bi bi-clock-history"></i> Menunggu
                                    Proses</p>
                                <h4 class="mb-0 text-warning fw-bold">{{ $pencairanStats['pending'] }}</h4>
                                <small class="text-muted">Perlu Tindakan</small>
                            </div>
                            <div class="ms-auto">
                                <div class="widget-icon bg-warning bg-opacity-10 text-warning rounded-circle"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-hourglass-split fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-0 shadow-sm" style="border-left: 4px solid #dc3545 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 text-secondary fw-semibold"><i class="bi bi-exclamation-triangle"></i>
                                    Ditolak</p>
                                <h4 class="mb-0 text-danger fw-bold">{{ $pencairanStats['ditolak'] }}</h4>
                                <small class="text-muted">Perlu Revisi</small>
                            </div>
                            <div class="ms-auto">
                                <div class="widget-icon bg-danger bg-opacity-10 text-danger rounded-circle"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-x-circle fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pencairan Status -->
        <div class="row my-4">
            <div class="col-12 col-lg-8">
                <div class="card radius-10 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 text-dark"><i class="bi bi-diagram-3"></i> Tahapan Proses Pencairan</h6>
                        <small class="text-muted">Alur proses dari pengajuan hingga pencairan</small>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-2 row-cols-md-5 g-2">
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none text-center">
                                    <div class="card-body py-2">
                                        <div class="widget-icon mx-auto mb-2 bg-warning text-dark"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            <i class="bi bi-arrow-up-circle"></i>
                                        </div>
                                        <h5 class="mb-1">{{ $pencairanStats['diajukan'] }}</h5>
                                        <p class="mb-0 small">Diajukan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none text-center">
                                    <div class="card-body py-2">
                                        <div class="widget-icon mx-auto mb-2 bg-info text-white"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            <i class="bi bi-search"></i>
                                        </div>
                                        <h5 class="mb-1">{{ $pencairanStats['diverifikasi'] }}</h5>
                                        <p class="mb-0 small">Diverifikasi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none text-center">
                                    <div class="card-body py-2">
                                        <div class="widget-icon mx-auto mb-2 bg-primary text-white"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <h5 class="mb-1">{{ $pencairanStats['disetujui'] }}</h5>
                                        <p class="mb-0 small">Disetujui</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none text-center">
                                    <div class="card-body py-2">
                                        <div class="widget-icon mx-auto mb-2 bg-success text-white"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            <i class="bi bi-check-all"></i>
                                        </div>
                                        <h5 class="mb-1">{{ $pencairanStats['dicairkan'] }}</h5>
                                        <p class="mb-0 small">Dicairkan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 mb-0 border shadow-none text-center">
                                    <div class="card-body py-2">
                                        <div class="widget-icon mx-auto mb-2 bg-danger text-white"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            <i class="bi bi-x-lg"></i>
                                        </div>
                                        <h5 class="mb-1">{{ $pencairanStats['ditolak'] }}</h5>
                                        <p class="mb-0 small">Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 text-dark"><i class="bi bi-lightning-charge"></i> Aksi Cepat</h6>
                        <small class="text-muted">Pintasan menu utama</small>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if (auth()->user()->hasPermissionTo('Create Pencairan') || auth()->user()->hasRole('Admin Lembaga'))
                                <a href="{{ route('permohonan') }}"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="bi bi-plus-circle me-2"></i> Buat Permohonan Baru
                                </a>
                            @endif
                            @if (auth()->user()->hasPermissionTo('Verify Pencairan') || auth()->user()->hasRole('Reviewer'))
                                <a href="{{ route('pencairan') }}"
                                    class="btn btn-warning d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clipboard-check me-2"></i> Verifikasi Pencairan
                                </a>
                            @endif
                            @if (auth()->user()->hasPermissionTo('Approve Pencairan') || auth()->user()->hasRole('Admin SKPD'))
                                <a href="{{ route('pencairan') }}"
                                    class="btn btn-info d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-circle me-2"></i> Setujui Pencairan
                                </a>
                            @endif
                            <a href="{{ route('pencairan') }}"
                                class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                <i class="bi bi-list-ul me-2"></i> Daftar Semua Pencairan
                            </a>
                            @if (auth()->user()->hasRole('Admin Lembaga'))
                                <a href="{{ route('permohonan') }}"
                                    class="btn btn-outline-success d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-earmark-text me-2"></i> Permohonan Saya
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end row-->

    </div>
    <!--end row-->

    <div class="modal fade" id="noAccessModal" tabindex="-1" aria-labelledby="noAccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-light text-center">
                    <h1 class="modal-title" id="noAccessModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Akses Ditolak
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center my-3">
                    <h3>
                        {{ session('no_access') ?? 'Kamu tidak memiliki hak akses ke halaman Tersebut.' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Row Keempat: Widget Tambahan -->
    <div class="row mt-4">
        <!-- Recent Activity Widget -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 text-dark">
                            <i class="bi bi-activity text-primary"></i> Aktivitas Terbaru
                        </h6>
                        <small class="text-muted">Update terakhir dari sistem</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">{{ count($recentActivity) }}</span>
                </div>
                <div class="card-body p-0">
                    @if (count($recentActivity) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($recentActivity as $activity)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-start border-0 py-3">
                                    <div class="ms-2 me-auto">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-{{ $activity['color'] }} me-2">
                                                <i class="{{ $activity['icon'] }}"></i>
                                            </span>
                                            <strong class="text-gray-800">{{ $activity['lembaga'] }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $activity['action'] }}</small>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="text-success fw-bold">
                                                Rp {{ number_format($activity['amount'], 0, ',', '.') }}
                                            </span>
                                            <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox text-muted fa-3x mb-3"></i>
                            <p class="text-muted mb-0">Belum ada aktivitas terbaru</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-center py-2">
                    <small class="text-muted">Update terakhir: {{ now()->format('d/m/Y H:i:s') }}</small>
                </div>
            </div>
        </div>

        <!-- Top Lembaga Widget -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 text-dark">
                            <i class="bi bi-award text-success"></i> Lembaga Teratas
                        </h6>
                        <small class="text-muted">Berdasarkan total pencairan {{ date('Y') }}</small>
                    </div>
                    <span class="badge bg-success rounded-pill">Top {{ count($topLembaga) }}</span>
                </div>
                <div class="card-body p-0">
                    @if (count($topLembaga) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($topLembaga as $index => $lembaga)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            @if ($index == 0)
                                                <span class="badge bg-warning rounded-circle"
                                                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-crown text-white"></i>
                                                </span>
                                            @elseif($index == 1)
                                                <span class="badge bg-secondary rounded-circle"
                                                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    2
                                                </span>
                                            @elseif($index == 2)
                                                <span class="badge bg-dark rounded-circle"
                                                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    3
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark rounded-circle"
                                                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border: 1px solid #dee2e6;">
                                                    {{ $index + 1 }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-gray-800">{{ $lembaga['name'] }}</div>
                                            <small class="text-muted">{{ $lembaga['total_permohonan'] }}
                                                permohonan</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-success fw-bold">
                                            Rp {{ number_format($lembaga['total_anggaran'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-building text-muted fa-3x mb-3"></i>
                            <p class="text-muted mb-0">Belum ada data lembaga</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row Kelima: Budget Progress -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 text-dark">
                            <i class="bi bi-pie-chart text-info"></i> Realisasi Anggaran Hibah
                            {{ $budgetProgress['year'] }}
                        </h6>
                        <small class="text-muted">Monitoring penggunaan anggaran tahunan</small>
                    </div>
                    <span
                        class="badge bg-info bg-opacity-10 text-info rounded-pill fs-6">{{ $budgetProgress['percentage'] }}%
                        Terealisasi</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Progress Bar -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Realisasi Anggaran</span>
                                    <span class="fw-bold">{{ $budgetProgress['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-gradient-info" role="progressbar"
                                        style="width: {{ $budgetProgress['percentage'] }}%"
                                        aria-valuenow="{{ $budgetProgress['percentage'] }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Budget Summary -->
                        <div class="col-md-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <div class="text-muted small">Total Anggaran</div>
                                        <div class="fw-bold text-primary">
                                            Rp {{ number_format($budgetProgress['total_anggaran'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <div class="text-muted small">Realisasi</div>
                                        <div class="fw-bold text-success">
                                            Rp {{ number_format($budgetProgress['total_realisasi'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted small">Sisa Anggaran</div>
                                    <div class="fw-bold text-warning">
                                        Rp {{ number_format($budgetProgress['sisa_anggaran'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (session('no_access'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Kalau pakai Bootstrap Modal
                let modalContent = `{{ session('no_access') }}`;

                // Contoh simple popup
                // alert(modalContent);

                // Atau kalau kamu punya modal custom, bisa trigger disini
                $('#noAccessModal').modal('show');
            });
        </script>
    @endif

    <script>
        let labels = @json($pencairan->keys());
        let chartData = @json($pencairan->values());

        var options = {
            series: [{
                name: "Pencairan",
                data: chartData
            }],
            chart: {
                foreColor: '#9a9797',
                type: "bar",
                //width: 130,
                height: 270,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 14,
                    blur: 4,
                    opacity: .12,
                    color: "#3461ff"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#3461ff", "#12bf24"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "40%",
                    endingShape: "rounded"
                }
            },
            legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'left',
                offsetX: -20
            },
            dataLabels: {
                enabled: !1
            },
            grid: {
                show: false,
                // borderColor: '#eee',
                // strokeDashArray: 4,
            },
            stroke: {
                show: !0,
                // width: 3,
                curve: "smooth"
            },
            colors: ["#12bf24"],
            xaxis: {
                categories: labels
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return "Rp. " + val + " Juta"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();
    </script>
@endpush
