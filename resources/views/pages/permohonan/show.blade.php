@extends('components.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Cek Permohonan</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan') }}">Permohonan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="pill" href="#data_lembaga" role="tab"
                        aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Lembaga</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="pill" href="#data_proposal" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Proposal</div>
                        </div>
                    </a>
                </li>
                @if ($permohonan->id_status >= 3)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="pill" href="#data_rab" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Data Rab</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="pill" href="#data_pendukung" role="tab"
                            aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Data Pendukung</div>
                            </div>
                        </a>
                    </li>
                @endif
                @if ($permohonan->status_rekomendasi != 0)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="pill" href="#status" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Status</div>
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="data_lembaga" role="tabpanel">

            <div class="card">
                <div class="card-body">
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="search" class="form-label">Nama Lembaga</label>
                            <input type="text" class="form-control" value="{{ $permohonan->lembaga->name }}" disabled>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label for="filter" class="form-label">Email</label>
                                    <input type="text" class="form-control" value="{{ $permohonan->lembaga->email }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label for="filter" class="form-label">No. Telp</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">+62</span>
                                        <input type="text" class="form-control" value="{{ $permohonan->lembaga->phone }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" rows="3" disabled>{{ $permohonan->lembaga->alamat }}"</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="data_proposal" role="tabpanel">
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <label class="form-label">Usulan APBD</label>
                        <input type="text" class="form-control" value="{{ $permohonan->tahun_apbd }}"
                            placeholder="2025" disabled>
                        @error('usulan_apbd')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Surat Permohonan --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-semibold mb-2">Surat Permohonan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">No Surat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $permohonan->no_mohon }}"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Perihal Surat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            value="{{ $permohonan->perihal_mohon }}" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Permohonan <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="bi bi-calendar"></i></span>
                                            <input type="date" class="form-control"
                                                value="{{ $permohonan->tanggal_mohon }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scan Permohonan <span
                                                class="text-danger">*</span></label><br>
                                        <button class="btn btn-warning">Lihat Dokumen</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Proposal --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">

                        <h3 class="font-semibold mt-6 mb-2">Proposal</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">No Proposal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $permohonan->no_proposal }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control"
                                            value="{{ $permohonan->tanggal_proposal }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Proposal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $permohonan->title }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKPD <span class="text-danger">*</span></label>
                            <select wire:model="id_skpd" id="id_skpd" class="form-control" disabled>
                                <option value="">-- Pilih SKPD --</option>
                                @foreach ($skpds as $key => $item)
                                    <option @selected($item->id == $permohonan->id_skpd) value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urusan <span class="text-danger">*</span></label>
                            <select wire:model="urusan" id="urusan" class="form-control" disabled>
                                <option value="">-- Pilih Urusan --</option>
                                @foreach ($urusans as $key => $item)
                                    <option @selected($item->id == $permohonan->urusan) value="{{ $item->id }}">
                                        {{ $item->nama_urusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Awal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control"
                                            value="{{ $permohonan->awal_laksana }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Akhir <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control"
                                            value="{{ $permohonan->akhir_laksana }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Scan Proposal <span class="text-danger">*</span></label><br>
                            <button class="btn btn-warning">Lihat Dokumen</button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Isi Proposal --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-semibold mt-6 mb-2">Ringkasan Proposal</h3>
                        <div class="mb-3">
                            <label class="form-label">Latar Belakang</label>
                            <textarea class="form-control" rows="3" disabled>{{ $permohonan->latar_belakang }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maksud Tujuan</label>
                            <textarea class="form-control" rows="3" disabled>{{ $permohonan->maksud_tujuan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="3" disabled>{{ $permohonan->keterangan }}</textarea>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-100">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="data_rab" role="tabpanel">
            <div class="card">
                <div class="card-body">


                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Rincian Kegiatan</th>
                                    <th>Volume</th>
                                    <th>Satuan<br>(Liter, KD, dan Sebagainya)</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatans as $kegiatan)
                                    <tr class="bg-warning">
                                        <td colspan="4" class="text-start">{{ $kegiatan->nama_kegiatan }}</td>
                                        <td class="text-end">
                                            {{ number_format(
                                                collect($kegiatan->rincian)->pluck('subtotal')->filter(fn($val) => is_numeric($val))->sum(),
                                                0,
                                                ',',
                                                '.',
                                            ) }}
                                        </td>
                                    </tr>
                                    @foreach ($kegiatan->rincian as $rincian)
                                        <tr class="">
                                            <td class="text-start">{{ $rincian->keterangan }}</td>
                                            <td>{{ $rincian->volume }}</td>
                                            <td class="text-start">{{ $rincian->satuan->name }}</td>
                                            <td class="text-end">{{ number_format($rincian->harga, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($rincian->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="data_pendukung" role="tabpanel">
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
                                data-file-url="{{ Storage::url($permohonan->pendukung->file_tidak_tumpang_tindih) }}">Lihat
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
                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($permohonan->file_proposal) }}">Lihat
                                    Dokumen</button>
                            </div>
                            <div class="mb-3">
                                <label for="surat_domisili" class="label-form">Proposal</label><br>
                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($permohonan->file_proposal) }}">Lihat
                                    Dokumen</button>
                            </div>
                        </div>
                        <div class=" col-4">
                            <div class="mb-3">
                                <label for="surat_domisili" class="label-form">Struktur Organisasi</label><br>
                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($permohonan->pendukung->struktur_pengurus) }}">Lihat
                                    Dokumen</button>
                            </div>
                            <div class="mb-3">
                                <label for="surat_domisili" class="label-form">Berkas RAB</label><br>
                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($permohonan->pendukung->file_rab) }}">Lihat
                                    Dokumen</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="surat_domisili" class="label-form">Foto Kondisi Saat Ini</label><br>
                                <button class="btn btn-warning w-100">Lihat Dokumen</button>
                            </div>
                            <div class="mb-3">
                                <label for="surat_domisili" class="label-form">Saldo Akhir Rekening Bank</label><br>
                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($permohonan->pendukung->saldo_akhir_rek) }}">Lihat
                                    Dokumen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="tab-pane fade @if ($permohonan->status_rekomendasi == 0) d-none @endif" id="status"
        role="tabpanel">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @if ($permohonan->status_rekomendasi == 1)
                    <h3>Permohonan Diterima dan Direkomendasikan</h3>
                @elseif($permohonan->status_rekomendasi == 2)
                    <h3>Permohonan Butuh Perbaikan</h3>
                @elseif($permohonan->status_rekomendasi == 3)
                    <h3>Permohonan Ditolak</h3>
                @endif
                @if ($permohonan->status_rekomendasi == 2)
                    <div wire:ignore.self class="row g-2" id="recomendation_row">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Rekomendasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="hidden" id="state_permohonan">
                                <input type="number" value="{{ $permohonan->nominal_rekomendasi }}"
                                    class="form-control" placeholder="Nominal" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Rekomendasi <span class="text-danger">*</span></label>
                            <input type="date" value="{{ $permohonan->tanggal_rekomendasi }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                @endif

                @if ($permohonan->status_rekomendasi == 2 || $permohonan->status_rekomendasi == 3)
                    <div wire:ignore.self class="mt-3" id="note_row">
                        <label class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea wire:model='catatan_rekomendasi' class="form-control" rows="2" disabled>{{ $permohonan->catatan_rekomendasi }}</textarea>
                    </div>
                @endif

                <div class="mt-3" id="notif_row">
                    <label class="form-label">Surat Pemberitahuan</label>
                    <div>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#fileModal"
                            data-file-url="{{ Storage::url($permohonan->file_pemberitahuan) }}">Lihat
                            Dokumen</button>
                    </div>
                </div>

                @if ($permohonan->status_rekomendasi == 2)
                    <div class="mt-4" id="revisi_permohonan">
                        <a href="{{ route('permohonan.revisi', ['id_permohonan' => $permohonan->id]) }}">
                            <button id="revisi_permohonan_button" class="btn btn-primary w-100">Lakukan Perbaikan</button>
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
