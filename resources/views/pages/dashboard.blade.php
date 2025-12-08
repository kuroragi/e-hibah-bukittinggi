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
            <div class="card radius-10 w-100">
                <div class="card-header">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Selamat Datang <span
                                    class="text-primary">{{ ucwords(auth()->user()->name) }}</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            @if (auth()->user()->hasRole('Super Admin'))
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Perngguna</p>
                                    <h4 class="mb-0 text-primary">{{ $user->count() }}</h4>
                                </div>
                                <div class="ms-auto fs-2 text-primary">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Lembaga</p>
                                    <h4 class="mb-0 text-success">{{ $lembaga->count() }}</h4>
                                </div>
                                <div class="ms-auto fs-2 text-success">
                                    <i class="bi bi-buildings"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Permohonan Dicairkan</p>
                                <h4 class="mb-0 text-success">{{ $permohonan->where('id_status', 14)->count() }}</h4>
                            </div>
                            <div class="ms-auto fs-2 text-success">
                                <i class="bi bi-patch-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Total Pencairan</p>
                                <h4 class="mb-0 text-pink">Rp.
                                    {{ number_format($permohonan->sum('nominal_anggaran'), 0, ',', '.') }}</h4>
                            </div>
                            <div class="ms-auto fs-2 text-pink">
                                Rp.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->



        <div class="row my-4">

            <div class="col-12 col-lg-12 col-xl-6 d-flex">
                <div class="card radius-10 w-100">
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
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Pencairan</h5> <small>Dalam Juta Rupiah*</small>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
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
                <h5 class="mb-3">Statistik Pencairan Dana Hibah</h5>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            <div class="col">
                <div class="card radius-10 bg-light-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1 text-secondary">Total Pencairan</p>
                                <h4 class="mb-0 text-info">{{ $pencairanStats['total'] }}</h4>
                            </div>
                            <div class="ms-auto fs-2 text-info">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-light-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1 text-secondary">Dana Dicairkan</p>
                                <h5 class="mb-0 text-success">Rp.
                                    {{ number_format($pencairanStats['totalDana'], 0, ',', '.') }}</h5>
                            </div>
                            <div class="ms-auto fs-2 text-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-light-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1 text-secondary">Menunggu Proses</p>
                                <h4 class="mb-0 text-warning">{{ $pencairanStats['pending'] }}</h4>
                            </div>
                            <div class="ms-auto fs-2 text-warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-light-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1 text-secondary">Ditolak</p>
                                <h4 class="mb-0 text-danger">{{ $pencairanStats['ditolak'] }}</h4>
                            </div>
                            <div class="ms-auto fs-2 text-danger">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pencairan Status -->
        <div class="row my-4">
            <div class="col-12 col-lg-8">
                <div class="card radius-10">
                    <div class="card-body">
                        <h6 class="mb-3">Status Pencairan Terperinci</h6>
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
                <div class="card radius-10">
                    <div class="card-body">
                        <h6 class="mb-3">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            @if (auth()->user()->hasPermissionTo('create pencairan') || auth()->user()->hasRole('Admin Lembaga'))
                                <a href="{{ route('permohonan') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle"></i> Ajukan Pencairan
                                </a>
                            @endif
                            @if (auth()->user()->hasPermissionTo('verify pencairan') || auth()->user()->hasRole('Reviewer'))
                                <a href="{{ route('pencairan') }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-search"></i> Verifikasi Pencairan
                                </a>
                            @endif
                            @if (auth()->user()->hasPermissionTo('approve pencairan') || auth()->user()->hasRole('Admin SKPD'))
                                <a href="{{ route('pencairan') }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-check2-all"></i> Approval Pencairan
                                </a>
                            @endif
                            <a href="{{ route('pencairan') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i> Lihat Semua Pencairan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end row-->

    </div>
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
    <div class="row">
        <!-- Recent Activity Widget -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                    </h6>
                    <span class="badge bg-primary">{{ count($recentActivity) }}</span>
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
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold text-success">
                        <i class="fas fa-trophy me-2"></i>Top Lembaga
                    </h6>
                    <span class="badge bg-success">{{ count($topLembaga) }}</span>
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
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold text-info">
                        <i class="fas fa-chart-pie me-2"></i>Progress Anggaran {{ $budgetProgress['year'] }}
                    </h6>
                    <span class="badge bg-info">{{ $budgetProgress['percentage'] }}%</span>
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
