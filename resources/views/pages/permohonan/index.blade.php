@extends('components.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Permohonan
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Permohonan
                    </li>
                </ol>
            </nav>
        </div>
        @if (auth()->user()->hasRole('Admin Lembaga'))
            <div class="ms-auto">
                <a href="{{ route('permohonan.create') }}">
                    <button type="button" class="btn btn-primary"><i class="bi bi-plus-lg"></i>Buat Pengajuan</button>
                </a>
            </div>
        @endif
    </div>
    <div>
        {{ auth()->user()->can('view_dukung', App\Models\Status_permohonan::class) }}
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if (!auth()->user()->hasRole('Admin Lembaga'))
                                <th>Lembaga</th>
                            @endif
                            <th>Rencanan Kegiatan / Rincian</th>
                            <th>Volume</th>
                            <th>Satuan (Liter, KD, dan Sebagainya)</th>
                            <th>Nama Satuan</th>
                            <th>Anggaran Pengajuan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tahun Pengajuan Hibah</th>
                            <th>SKPD</th>
                            <th>Nominal Pengajuan Awal</th>
                            <th>Nominal Pengajuan Anggaran</th>
                            <th>Nominal Rekomendasi</th>
                            <th>Nominal APBD</th>
                            <th>Status Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permohonan as $key => $item)
                            <tr @if ($item->id_status == 8) class="bg-warning" @endif>
                                <td>{{ $loop->iteration }}</td>
                                @if (!auth()->user()->hasRole('Admin Lembaga'))
                                    <td>{{ $item->lembaga->name }}</td>
                                @endif
                                <td>{{ $item->perihal_mohon }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $item->tanggal_mohon }}</td>
                                <td>{{ $item->tahun_apbd }}</td>
                                <td>{{ $item->skpd->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-between"><span>Rp.</span>
                                        <span>{{ number_format($item->nominal_rab ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-between"><span>Rp.</span>
                                        <span>{{ number_format($item->nominal_anggaran ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between"><span>Rp.</span>
                                        <span>{{ number_format($item->nominal_rekomendasi ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between"><span>Rp.</span>
                                        <span>{{ number_format($item->nominal_rekomendasi ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @status_buttons([$item->status->status_button, App\Models\Permohonan::class, $item->id, $item->id_status])
                                </td>
                                <td class="text-center">
                                    @action_buttons([$item->status->action_buttons, App\Models\Permohonan::class, $item->id])
                                    @if ($item->id_status == 8)
                                        @can('download_pemberitahuan', App\Models\Permohonan::class)
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#fileModal"
                                                data-file-url="{{ Storage::url($item->file_pemberitahuan) }}"><i
                                                    class="bi bi-cloud-download-fill"></i></button>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            @if (!auth()->user()->hasRole('Admin Lembaga'))
                                <th>Lembaga</th>
                            @endif
                            <th>Rencanan Kegiatan / Rincian</th>
                            <th>Volume</th>
                            <th>Satuan (Liter, KD, dan Sebagainya)</th>
                            <th>Nama Satuan</th>
                            <th>Anggaran Pengajuan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tahun Pengajuan Hibah</th>
                            <th>SKPD</th>
                            <th>Nominal Pengajuan Awal</th>
                            <th>Nominal Pengajuan Anggaran</th>
                            <th>Nominal Rekomendasi</th>
                            <th>Nominal APBD</th>
                            <th>Nominal Status Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#download_pemberitahuan").click(function() {
                setTimeout(() => {
                    window.location.href = "{{ route('permohonan') }}"; // route baru
                }, 2000); // kasih delay biar download sempat jalan
            })
        });
    </script>
@endpush
