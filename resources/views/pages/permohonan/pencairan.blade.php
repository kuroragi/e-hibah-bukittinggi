@extends('components.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pencairan
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pencairan
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        @if (!auth()->user()->hasRole('Admin Lembaga'))
                            <th>Lembaga</th>
                        @endif
                        <th>Judul Proposal</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tahun Pengajuan Hibah</th>
                        <th>Nominal Anggaran Pengajuan</th>
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
                            <td>{{ $item->tanggal_mohon }}</td>
                            <td>Penetapan APBD {{ $item->tahun_apbd }}</td>
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
                                {{-- @action_buttons([$item->status->action_buttons, App\Models\Permohonan::class,
                        $item->id]) --}}
                                {{-- <a href="{{ route('nphd.show', ['id_permohonan' => $item->id]) }}"><button
                                class="btn btn-sm btn-warning" title="Detail NPHD"><i
                                    class="bi bi-pencil-square"></i></button></a> --}}
                                <div class="col">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning"><i
                                                class="bi bi-menu-button"></i></button>
                                        <button type="button"
                                            class="btn btn-sm btn-warning split-bg-warning dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false"> <span
                                                class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if (!$item->nphd()->count() > 0 && auth()->user()->hasRole('Admin Lembaga'))
                                                <li>
                                                    <a class="dropdown-item" href="javascript;" data-bs-toggle="modal"
                                                        data-bs-target="#upload_nphd_modal" data-id="{{ $item->id }}"
                                                        id="upload_nphd_button"><i class="bi bi-upload"></i> Upload
                                                        NPHD</a>
                                                </li>
                                            @elseif($item->nphd()->count() > 0)
                                                <li>
                                                    <a class="dropdown-item" href="javascript:"><i
                                                            class="bi bi-check text-success"></i> NPHD</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('pencairan.data_pendukung', ['id_permohonan' => $item->id]) }}"
                                                        class="dropdown-item">Cek Pendukung Pencairan</a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" href="javascript:"><i
                                                            class="bi bi-x-lg text-danger"></i> NPHD</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
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
                        <th>Judul Proposal</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tahun Pengajuan Hibah</th>
                        <th>Nominal Anggaran Pengajuan</th>
                        <th>Nominal Rekomendasi</th>
                        <th>Nominal APBD</th>
                        <th>Status Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal fade" id="upload_nphd_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light">Upload NPHD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pencairan.upload_nphd') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_nphd" class="form-label">No. NPHD</label>
                                            <div class="input-group">
                                                <span class="input-group-text">No. NPHD
                                                    {{ $permohonan->skpd?->name }}</span>
                                                <input type="text" class="form-control" name="no_nphd_skpd"
                                                    id="no_nphd" value="{{ old('no_nphd') }}">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">No. NPHD
                                                    {{ $permohonan->lembaga?->name }}</span>
                                                <input type="text" class="form-control" name="no_nphd_lembaga"
                                                    id="no_nphd" value="{{ old('no_nphd') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tanggal_nphd" class="form-label">Tanggal NPHD</label>
                                            <input type="date" class="form-control" name="tanggal_nphd"
                                                id="tanggal_nphd" value="{{ old('tanggal_nphd') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="permissionName" class="form-label">Scan NPHD</label>
                                    <input type="hidden" name="id_permohonan" id="id_permohonan">
                                    <input type="file" name="file_nphd" class="form-control" id="permissionName"
                                        placeholder="Masukkan nama permission">
                                </div>
                                <div class="mb-3">
                                    <label for="nilai_disetujui" class="form-label">Nilai Disetujui</label>
                                    <input type="number" class="form-control" name="nilai_disetujui"
                                        id="nilai_disetujui" value="{{ old('nilai_disetujui') }}">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_permohonan" class="form-label">No. Permohonan Pencairan</label>
                                            <input type="text" class="form-control" name="no_permohonan"
                                                id="no_permohonan" value="{{ old('no_permohonan') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tanggal_permohonan" class="form-label">Tanggal Permohonan</label>
                                            <input type="date" class="form-control" name="tanggal_permohonan"
                                                id="tanggal_permohonan" value="{{ old('tanggal_permohonan') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="file_permohonan" class="form-label">Scan Permohonan</label>
                                    <input type="file" name="file_permohonan" class="form-control"
                                        id="file_permohonan" placeholder="Masukkan file scan permohonan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#upload_nphd_button").on("click", function() {
                let id = $(this).attr("data-id");
                $("#id_permohonan").val(id);
            })
        });
    </script>
@endpush
