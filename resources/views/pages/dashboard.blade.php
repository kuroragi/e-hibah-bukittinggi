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

        @if (auth()->user()->hasRole('Super Admin'))
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3">
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
                            {{-- <div class="border-top my-2"></div>
                            <small class="mb-0"><span class="text-success">+2.5 <i class="bi bi-arrow-up"></i></span>
                                Compared
                                to
                                last month</small> --}}
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
                            {{-- <div class="border-top my-2"></div>
                            <small class="mb-0"><span class="text-success">+3.6 <i class="bi bi-arrow-up"></i></span>
                                Compared
                                to
                                last month</small> --}}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Total Pencairan</p>
                                    <h4 class="mb-0 text-pink">Rp. 0</h4>
                                </div>
                                <div class="ms-auto fs-2 text-pink">
                                    <i class="bi bi-patch-check"></i>
                                </div>
                            </div>
                            {{-- <div class="border-top my-2"></div>
                            <small class="mb-0"><span class="text-danger">-1.8 <i class="bi bi-arrow-down"></i></span>
                                Compared to
                                last month</small> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        @endif

        <div class="row">
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
                                            {{ $permohonan->whereIn('id_status', [8, 10, 11, 12])->count() }}
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
    </div>
    <!--end row-->
@endsection

@push('scripts')
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
