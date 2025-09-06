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
            <div class="table-responsive">
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
                                    @action_buttons([$item->status->action_buttons, App\Models\Permohonan::class, $item->id])
                                    {{-- <a href="{{ route('nphd.show', ['id_permohonan' => $item->id]) }}"><button
                                            class="btn btn-sm btn-warning" title="Detail NPHD"><i
                                                class="bi bi-pencil-square"></i></button></a> --}}
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
    </div>
@endsection
