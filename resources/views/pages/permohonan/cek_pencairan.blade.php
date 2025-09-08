@extends('components.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Data Dukung Pencairan
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    <li class="breadcrumb-item"><a href="{{ route('pencairan') }}">Pencairan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Dukung Pencairan
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

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <label for="surat_domisili" class="label-form">Surat Domisili</label><br>
                    <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                        data-file-url="{{ Storage::url($permohonan->lembaga->file_domisili) }}">Lihat
                        Dokumen</button>
                </div>
                <div class="col-4">
                    <label for="surat_domisili" class="label-form">Izin Operasional</label><br>
                    <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                        data-file-url="{{ Storage::url($permohonan->lembaga->file_operasional) }}">Lihat
                        Dokumen</button>
                </div>
                <div class="col-4">
                    <label for="surat_domisili" class="label-form">Surat Penyataan Tidak Tumpang
                        Tindih</label><br>
                    <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                        data-file-url="{{ Storage::url($permohonan->lembaga->file_pernyataan) }}">Lihat
                        Dokumen</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="surat_domisili" class="label-form">Surat Pertanggung Jawaban</label><br>
                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                            data-bs-target="#fileModal"
                            data-file-url="{{ Storage::url($permohonan->file_pernyataan_tanggung_jawab) }}">Lihat
                            Dokumen</button>
                    </div>
                    <div class="mb-3">
                        <label for="surat_domisili" class="label-form">Proposal</label><br>
                        <div class="mb-3">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($permohonan->file_proposal) }}">Lihat
                                Dokumen</button>
                        </div>
                    </div>
                </div>
                <div class=" col-4">
                    <div class="mb-3">
                        <label for="surat_domisili" class="label-form">Struktur Organisasi</label><br>
                        <div class="mb-3">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($permohonan->pendukung->struktur_pengurus) }}">Lihat
                                Dokumen</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="surat_domisili" class="label-form">Berkas RAB</label><br>
                        <div class="mb-3">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($permohonan->pendukung->file_rab) }}">Lihat
                                Dokumen</button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="surat_domisili" class="label-form">Saldo Akhir Rekening Bank</label><br>
                        <div class="mb-3">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($permohonan->pendukung->saldo_akhir_rek) }}">Lihat
                                Dokumen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
