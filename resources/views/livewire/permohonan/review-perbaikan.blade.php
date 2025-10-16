<div>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Permohonan</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan') }}">Permohonan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Review Perbaikan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <a wire:ignore.self class="nav-link @if (!$is_lembaga_verif && !$is_proposal_verif && !$is_pendukung_verif) show active @endif"
                        data-bs-toggle="pill" href="#data_lembaga" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Lembaga</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a wire:ignore.self class="nav-link @if ($is_lembaga_verif && !$is_proposal_verif && !$is_pendukung_verif) show active @endif"
                        data-bs-toggle="pill" href="#data_proposal" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Proposal</div>
                        </div>
                    </a>
                </li>
                @if ($permohonan->id_status >= 3)
                    <li class="nav-item" role="presentation">
                        <a wire:ignore.self class="nav-link @if ($is_lembaga_verif && $is_proposal_verif && !$is_pendukung_verif) show active @endif"
                            data-bs-toggle="pill" href="#data_rab" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Data Rab</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a wire:ignore.self class="nav-link" data-bs-toggle="pill" href="#data_pendukung" role="tab"
                            aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Data Pendukung</div>
                            </div>
                        </a>
                    </li>
                @endif
                @if ($permohonan->id_status >= 11)
                    <li class="nav-item" role="presentation">
                        <a wire:ignore.self class="nav-link @if ($is_lembaga_verif && $is_proposal_verif && $is_pendukung_verif) show active @endif"
                            data-bs-toggle="pill" href="#berita_acara" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">Berita Acara</div>
                            </div>
                        </a>
                    </li>
                @endif
                @if ($permohonan->id_status >= 12)
                    <li class="nav-item" role="presentation">
                        <a wire:ignore.self class="nav-link" data-bs-toggle="pill" href="#status" role="tab"
                            aria-selected="false">
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
        <div wire:ignore.self class="tab-pane fade @if (!$is_lembaga_verif && !$is_proposal_verif && !$is_pendukung_verif) show active @endif"
            id="data_lembaga" role="tabpanel">

            <div class="card bg-secondary">
                <div class="card-body">
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="search" class="form-label">Nama Lembaga</label>
                            <input type="text" class="form-control" value="{{ $permohonan->lembaga->name }}"
                                disabled>
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
                                        <input type="text" class="form-control"
                                            value="{{ $permohonan->lembaga->phone }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" rows="3" disabled>{{ $permohonan->lembaga->alamat }}"</textarea>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="checkbox" wire:model='is_lembaga_verif' @checked($is_lembaga_verif)
                                    id="is_lembaga_verif_checkbox">
                                <span class="text-start ms-3">Data Lembaga Telah Dilakukan Pengecekan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="tab-pane fade @if ($is_lembaga_verif && !$is_proposal_verif && !$is_pendukung_verif) show active @endif"
            id="data_proposal" role="tabpanel">
            <div class="mb-4">
                <div class="card bg-secondary">
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
                <div class="card bg-secondary">
                    <div class="card-body">
                        <h3 class="font-semibold mb-2">Surat Permohonan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">No Surat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            value="{{ $permohonan->no_mohon }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Perihal Surat <span
                                                class="text-danger">*</span></label>
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
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ Storage::url($permohonan->file_mohon) }}">Lihat
                                            Dokumen</button>
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

                        <h3 class="font-semibold mt-6 mb-2">Proposal yang diperbaiki</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">No Proposal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        value="{{ $permohonan->perbaikanProposal->last()->no_proposal }}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengajuan <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control"
                                            value="{{ $permohonan->perbaikanProposal->last()->tanggal_perbaikan }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Proposal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"
                                value="{{ $permohonan->perbaikanProposal->last()->judul_proposal }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKPD <span class="text-danger">*</span></label>
                            <select wire:model="id_skpd" id="id_skpd" class="form-control" disabled>
                                <option value="">-- Pilih SKPD --</option>
                                @foreach ($skpds as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urusan <span class="text-danger">*</span></label>
                            <select wire:model="urusan" id="urusan" class="form-control" disabled>
                                <option value="">-- Pilih Urusan --</option>
                                @foreach ($urusans as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_urusan }}</option>
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
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Scan Proposal yang diperbaiki <span
                                            class="text-danger">*</span></label><br>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ Storage::url($permohonan->perbaikanProposal->last()->file_proposal) }}">Lihat
                                            Dokumen</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Scan Proposal sebelum diperbaiki <span
                                            class="text-danger">*</span></label><br>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ Storage::url($permohonan->file_proposal) }}">Lihat
                                            Dokumen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Isi Proposal --}}
            <div class="mb-4">
                <div class="card bg-secondary">
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
                        <div class="row">
                            <div class="col-12">
                                <input type="checkbox" wire:model='is_proposal_verif' @checked($is_proposal_verif)
                                    id="is_proposal_verif_checkbox">
                                <span class="text-start ms-3">Data Proposal Telah Dilakukan Pengecekan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="tab-pane fade @if ($is_lembaga_verif && $is_proposal_verif && !$is_pendukung_verif) show active @endif"
            id="data_rab" role="tabpanel">
            <div class="card">
                <div class="card-body">


                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatans as $kegiatan)
                                    <tr>
                                        <td class="text-start">{{ $kegiatan->nama_kegiatan }}</td>
                                        <td class="text-end">
                                            {{ number_format($kegiatan->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-warning">
                                    <td class="text-start fw-bold">Total</td>
                                    <td class="text-end fw-bold">
                                        {{ number_format($permohonan->nominal_anggaran, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="tab-pane fade" id="data_pendukung" role="tabpanel">
            <div class="card mb-3 bg-secondary">
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
            <div class="card mb-3 bg-secondary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="surat_domisili" class="label-form">Surat Pertanggung Jawaban</label><br>
                                <button class="btn btn-warning w-100">Lihat Dokumen</button>
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
                                <label for="surat_domisili" class="label-form">Foto Kondisi Saat Ini</label><br>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                        data-bs-target="#fileModal"
                                        data-file-url="{{ Storage::url($permohonan->pendukung->struktur_pengurus) }}">Lihat
                                        Dokumen</button>
                                </div>
                            </div>
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
                        <div class="row">
                            <div class="col-12">
                                <input type="checkbox" wire:model='is_pendukung_verif' @checked($is_pendukung_verif)
                                    id="is_pendukung_verif_checkbox">
                                <span class="text-start ms-3">Data Pendukung Telah Dilakukan Pengecekan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="tab-pane fade @if ($is_lembaga_verif && $is_proposal_verif && $is_pendukung_verif) show active @endif"
            id="berita_acara" role="tabpanel">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">
                        Checklist Kesesuaian Data Antara Dokumen Tertulis Dan SoftCopy <br>
                        <small>(Berdasarkan Pergub 27 Tahun 2023)</small>
                    </h5>

                    <div class="mb-4">
                        <table class="table table-bordered mt-4">
                            <thead class="table-secondary text-center align-middle">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Data Administrasi</th>
                                    <th style="width: 10%;">Ada</th>
                                    <th style="width: 10%;">Sesuai</th>
                                    <th style="width: 30%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $item)
                                    <tr wire:key="parent-{{ $item->id }}" class="bg-warning">
                                        <td colspan="2">{{ $item->question }}</td>
                                        <td class="text-center"><input type="checkbox" name="ada_1"></td>
                                        <td class="text-center"><input type="checkbox" name="sesuai_1"></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($item->children as $child)
                                        <tr wire:key="child-{{ $child->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="wrap-text">{{ $child->question }}</td>
                                            <td class="text-center"><input type="checkbox"
                                                    wire:model='answer.{{ $child->id }}.is_ada'
                                                    @checked($answer[$child->id]['is_ada'] == 1) @disabled($permohonan->id_status > 5)>
                                            </td>
                                            <td class="text-center"><input type="checkbox"
                                                    wire:model='answer.{{ $child->id }}.is_sesuai'
                                                    @checked($answer[$child->id]['is_ada'] == 1) @disabled($permohonan->id_status > 5)></td>
                                            <td><input type="text"
                                                    wire:model='answer.{{ $child->id }}.keterangan'
                                                    class="form-control" @disabled($permohonan->id_status > 5)></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <div class="row">
                            <div class="col-1 text-center">
                                <input wire:model='is_lengkap' @checked($is_lengkap == 1) type="checkbox"
                                    @disabled($permohonan->id_status > 5)>
                            </div>
                            <div class="col-11">
                                <p>Dengan ini saya menyatakan proposal ini telah dilakukan verifikasi kesesuaian,
                                    kelengkapan,
                                    keabsahan antar dokumen tertulis & software (Berdasarkan pergub 27 tahun 2023)
                                    serta
                                    kelayakan
                                    usulan hibahnya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">
                        Perubahan Dokumen Tertulis Dan SoftCopy
                    </h5>

                    <div class="mb-4">
                        <table class="table table-bordered mt-4">
                            <thead class="table-secondary text-center align-middle">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Kelengkapan</th>
                                    <th style="width: 10%;">Ada</th>
                                    <th style="width: 10%;">Sesuai</th>
                                    <th style="width: 30%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-warning">
                                    <td colspan="2">Kelengkapan Data Proposal dan RAB Setelah diperbaiki</td>
                                    <td class="text-center"><input type="checkbox" name="ada_1"></td>
                                    <td class="text-center"><input type="checkbox" name="sesuai_1"></td>
                                    <td></td>
                                </tr>
                                @foreach ($list_kelengkapan_perbaikan as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['question'] }}</td>

                                        <td wire class="text-center"><input
                                                wire:model='list_kelengkapan_perbaikan.{{ $key }}.is_ada'
                                                type="checkbox">
                                        </td>
                                        <td class="text-center"><input
                                                wire:model='list_kelengkapan_perbaikan.{{ $key }}.is_sesuai'
                                                type="checkbox"></td>
                                        <td><input
                                                wire:model='list_kelengkapan_perbaikan.{{ $key }}.keterangan'
                                                type="text" class="form-control"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <div class="row">
                            <div class="col-1 text-center">
                                <input wire:model='is_lengkap_perbaikan' type="checkbox">
                            </div>
                            <div class="col-11">
                                <p>Dengan ini saya menyatakan proposal ini telah dilakukan review ulang dengan
                                    kesesuaian,
                                    kelengkapan,
                                    keabsahan antar dokumen tertulis & software (Berdasarkan pergub 27 tahun 2023)
                                    serta
                                    kelayakan
                                    usulan hibahnya</p>
                            </div>
                        </div>
                        <div class="row">
                            <button wire:click='storeReviewPerbaikan' class="btn btn-warning w-100">Submit Berita
                                Acara Perbaikan Dan Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-secondary">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <div class="fw-bold mb-3">Apakah Data telah diverifikasi kelengkapan keabsahan dan kelayakan
                            usulan
                            hibahnya?</div>
                        <div>
                            <button wire:click='hasVeriffied' class="btn btn-primary me-4"
                                @disabled($permohonan->id_status > 5)>Ya</button>
                            <button wire:click='store(0)' class="btn btn-danger"
                                @disabled($permohonan->id_status > 5)>Tidak</button>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="$wire.veriffied == true" class="card bg-secondary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Kelengkapan Administrasi <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model='file_kelengkapan_adm' class="form-control"
                                    @disabled($permohonan->id_status > 5)>
                                <div class="progress mt-2" wire:loading wire:target="file_kelengkapan_adm">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" style="width: 100%;">
                                        Uploading...
                                    </div>
                                </div>
                                @error('file_kelengkapan_adm')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">No <span class="text-danger">*</span></label>
                                <input type="text" wire:model='no_kelengkapan_adm' class="form-control"
                                    @disabled($permohonan->id_status > 5)>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" wire:model='tanggal_kelengkapan_adm' class="form-control"
                                    @disabled($permohonan->id_status > 5)>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-3">
                            @if ($berita_acara)
                                <button class="btn btn-warning w-100" data-bs-toggle="modal"
                                    data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($berita_acara->file_kelengkapan_adm) }}">Lihat
                                    Dokumen</button>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Berita Acara Peninjauan Lapangan <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model='file_tinjau_lap' class="form-control"
                                    @disabled($permohonan->id_status > 5)>
                                <div class="progress mt-2" wire:loading wire:target="file_tinjau_lap">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" style="width: 100%;">
                                        Uploading...
                                    </div>
                                </div>
                                @error('file_tinjau_lap')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">No <span class="text-danger">*</span></label>
                                <input type="text" wire:model='no_tinjau_lap' class="form-control"
                                    @disabled($permohonan->id_status > 5)>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" wire:model='tanggal_tinjau_lap' class="form-control"
                                    @disabled($permohonan->id_status > 5)>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-3">
                            @if ($berita_acara)
                                <button class="btn btn-warning w-100" data-bs-toggle="modal"
                                    data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($berita_acara->file_tinjau_lap) }}">Lihat
                                    Dokumen</button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <button wire:click='store_berita_acara(1)' class="btn btn-primary w-100"
                            @disabled($permohonan->id_status > 5)>Simpan</button>
                    </div>
                </div>
            </div>

        </div>
        <div wire:ignore.self class="tab-pane fade" id="status">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Proposal</label>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <button wire:click='recomending' type="button" class="btn btn-outline-dark w-100"
                                    id="recomended_button">Direkomendasi</button>
                            </div>
                            <div class="col-3">
                                <button wire:click='correcting' type="button" class="btn btn-primary w-100"
                                    id="correction_button">Dikoreksi</button>
                            </div>
                            <div class="col-3">
                                <button wire:click='deniying' type="button" class="btn btn-outline-danger w-100"
                                    id="denied_button">Ditolak</button>
                            </div>
                        </div>
                    </div>

                    <div wire:ignore.self class="row g-2 d-none" id="recomendation_row">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Rekomendasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="hidden" id="state_permohonan">
                                <input type="number" wire:model='nominal_rekomendasi' class="form-control"
                                    placeholder="Nominal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Rekomendasi <span class="text-danger">*</span></label>
                            <input type="date" wire:model='tanggal_rekomendasi' class="form-control">
                        </div>
                    </div>

                    <div wire:ignore.self class="mt-3 d-none" id="note_row">
                        <label class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea wire:model='catatan_rekomendasi' class="form-control" rows="2"></textarea>
                    </div>

                    <div wire:ignore.self class="mt-3 d-none" id="notif_row">
                        <label class="form-label">Surat Pemberitahuan</label>
                        <input type="file" wire:model='file_pemberitahuan_perbaikan' class="form-control">
                    </div>

                    <div wire:ignore.self class="mt-4 d-none" id="save_status_button">
                        <button wire:click='store_pemberitahuan_perbaikan' id="store_pemberitahuan_perbaikan"
                            class="btn btn-primary w-100">Simpan</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


@push('scripts')
    <script>
        $(document).ready(function() {

            let state;

            $("#recomended_button").on("click", function() {
                $("#recomendation_row").addClass("d-none");
                $("#note_row").addClass("d-none");
                $("#notif_row").removeClass("d-none");
                $("#save_status_button").removeClass("d-none");
                // $("#state_permohonan").val(1);
                state = 1;
            });

            $("#correction_button").on("click", function() {
                $("#recomendation_row").removeClass("d-none");
                $("#note_row").removeClass("d-none");
                $("#notif_row").removeClass("d-none");
                $("#save_status_button").removeClass("d-none");
                // $("#state_permohonan").val(2);
                state = 2;
                console.log(state);

            });

            $("#denied_button").on("click", function() {
                $("#recomendation_row").addClass("d-none");
                $("#note_row").removeClass("d-none");
                $("#notif_row").addClass("d-none");
                $("#save_status_button").removeClass("d-none");
                // $("#state_permohonan").val(3);
                state = 3
            });

            $("#store_pemberitahuan_perbaikan").on("click", function() {
                console.log("clicked");

                $wire.store_pemberitahuan(state);
            })
        });
    </script>
@endpush
