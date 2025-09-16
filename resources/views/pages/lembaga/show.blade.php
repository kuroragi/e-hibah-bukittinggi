{{-- @extends('components.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Lembaga
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Permohonan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('permohonan.create') }}">
                <button type="button" class="btn btn-primary"><i class="bi bi-plus-lg"></i>Buat Pengajuan</button>
            </a>

        </div>
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
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->perihal_mohon }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $item->tanggal_mohon }}</td>
                                <td>{{ $item->tahun_apbd }}</td>
                                <td>{{ $item->skpd->name }}</td>
                                <td>Rp. {{ $item->nominal_rab ?? 0 }}</td>
                                <td></td>
                                <td></td>
                                <td>Rp. {{ $item->nominal_rekomendasi ?? 0 }}</td>
                                <td>
                                    @status_buttons([$item->status->status_button, App\Models\Status_permohonan::class, $item->id_status])
                                </td>
                                <td class="text-center">
                                    @action_buttons([$item->status->action_buttons, App\Models\Status_permohonan::class, $item->id])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
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
@endsection --}}

@extends('components.layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Lembaga</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Lembaga</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs nav-primary" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#profil_nav" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                            </div>
                            <div class="tab-title">Profil</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#pendukung_nav" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                            </div>
                            <div class="tab-title">Data pendukung</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#pengurus_nav" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                            </div>
                            <div class="tab-title">Pengurus</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="profil_nav" role="tabpanel">
                <div class="row">
                    <div class="col col-md-9 p-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="col col-12">
                                    <div class="mb-3">
                                        <label for="search" class="form-label">Cari Lembaga</label>
                                        <input type="text" class="form-control" value="{{ $lembaga->name }}" disabled>
                                    </div>
                                    <div class="row">
                                        <div class="col col-6">
                                            <div class="mb-3">
                                                <label for="filter" class="form-label">Email</label>
                                                <input type="text" class="form-control" value="{{ $lembaga->email }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col col-6">
                                            <div class="mb-3">
                                                <label for="filter" class="form-label">No. Telp</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text">+62</span>
                                                    <input type="text" class="form-control" value="{{ $lembaga->phone }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" rows="3" disabled>{{ $lembaga->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ optional($lembaga)->photo ? Storage::url($lembaga->photo) : asset('assets/images/logo/lembaga.jpg') }}"
                                        alt="Avatar" class="rounded-circle img-fluid mb-3"
                                        style="width: 100px; height: 100px;">
                                    <h5 class="mb-0">{{ $lembaga->name }}</h5>
                                    <h5 class="mb-0">{{ $lembaga->pengurus[0]->name }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pendukung_nav" role="tabpanel">
                <div class="row">
                    <div class="col col-12 p-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="npwp" class="form-label">No. NPWP <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="npwp" id="npwp"
                                        value="{{ $lembaga->npwp }}" disabled required>
                                    @error('npwp')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Akta Kumham -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Akta Kumham/ SK Lembaga <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_akta_kumham"
                                            value="{{ $lembaga->no_akta_kumham }}" disabled required>
                                        @error('no_akta_kumham')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_akta_kumham"
                                            value="{{ $lembaga->date_akta_kumham }}" disabled required>
                                        @error('date_akta_kumham')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file_akta_kumham"
                                            value="{{ old('file_akta_kumham') }}" disabled required>
                                        @error('file_akta_kumham')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ asset('storage/' . $lembaga->file_akta_kumham) }}">
                                            Lihat Dokumen Akta Kumham / SK</button>
                                    </div>
                                </div>

                                <!-- Surat Domisili -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Surat Domisili <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_domisili"
                                            value="{{ $lembaga->no_domisili }}" disabled required>
                                        @error('no_domisili')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_domisili"
                                            value="{{ $lembaga->date_domisili }}" disabled required>
                                        @error('date_domisili')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file_domisili"
                                            value="{{ old('file_domisili') }}" disabled required>
                                        @error('file_domisili')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ asset('storage/' . $lembaga->file_domisili) }}">
                                            Lihat Dokumen Domisili</button>
                                    </div>
                                </div>

                                <!-- Izin Operasional -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Izin Operasional/ Tanda Daftar Lembaga <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_operasional"
                                            value="{{ $lembaga->no_operasional }}" disabled required>
                                        @error('no_operasional')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_operasional"
                                            value="{{ $lembaga->date_operasional }}" disabled required>
                                        @error('date_operasional')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file_operasional"
                                            value="{{ old('file_operasional') }}" disabled required>
                                        @error('file_operasional')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ asset('storage/' . $lembaga->file_operasional) }}">
                                            Lihat Dokumen Operasion</button>
                                    </div>
                                </div>

                                <!-- Surat Pernyataan -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Surat Pernyataan Tidak Tumpang Tindih <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_pernyataan"
                                            value="{{ $lembaga->no_pernyataan }}" disabled required>
                                        @error('no_pernyataan')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_pernyataan"
                                            value="{{ $lembaga->date_pernyataan }}" disabled required>
                                        @error('date_pernyataan')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file_pernyataan"
                                            value="{{ old('file_pernyataan') }}" disabled required>
                                        @error('file_pernyataan')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ asset('storage/' . $lembaga->file_pernyataan) }}">
                                            Lihat Dokumen Tidak Tumpang Tindih</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card shadow sm">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="search" class="form-label">Nama Bank <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" value="{{ $lembaga->id_bank }}"
                                                disabled>
                                            @error('nama_bank')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <label for="filter" class="form-label">Atas Nama <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                value="{{ $lembaga->no_rekening }}" disabled>
                                            @error('atas_nama')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="search" class="form-label">No. Rekening <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                value="{{ $lembaga->no_rekening }}" disabled>
                                            @error('no_rekening')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="filter" class="form-label">Scan Rekening <small
                                                    class="text-danger">*</small></label>
                                            <input type="file" class="form-control"
                                                value="{{ old('scan_rekening') }}" disabled>
                                            @error('scan_rekening')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                            <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal"
                                                data-bs-target="#fileModal"
                                                data-file-url="{{ Storage::url($lembaga->photo_rek) }}">Lihat
                                                Photo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-4" id="pengurus_nav" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header h4">
                        Pimpinan Badan/ Lembaga atau Sebutan Lainnya
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name_pimpinan"
                                    value="{{ $lembaga->pengurus[0]->name }}" disabled required>
                                @error('name_pimpinan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_pimpinan"
                                    value="{{ $lembaga->pengurus[0]->email }}" disabled required>
                                @error('email_pimpinan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nik"
                                    value="{{ $lembaga->pengurus[0]->nik }}" disabled required>
                                @error('nik')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="{{ $lembaga->pengurus[0]->no_hp }}" disabled required>
                                @error('no_hp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="scan_ktp"
                                    value="{{ $lembaga->pengurus[0]->scan_ktp }}" disabled required>
                                @error('scan_ktp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" name="alamat_pimpinan" disabled required>{{ $lembaga->pengurus[0]->alamat }}</textarea>
                            @error('alamat_pimpinan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header h4">
                        Sekretaris
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name_pimpinan"
                                    value="{{ $lembaga->pengurus[1]->name }}" disabled required>
                                @error('name_pimpinan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_pimpinan"
                                    value="{{ $lembaga->pengurus[1]->email }}" disabled required>
                                @error('email_pimpinan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nik"
                                    value="{{ $lembaga->pengurus[1]->nik }}" disabled required>
                                @error('nik')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="{{ $lembaga->pengurus[1]->no_hp }}" disabled required>
                                @error('no_hp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="scan_ktp"
                                    value="{{ $lembaga->pengurus[1]->scan_ktp }}" disabled required>
                                @error('scan_ktp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" name="alamat_pimpinan" disabled required>{{ $lembaga->pengurus[1]->alamat }}</textarea>
                            @error('alamat_pimpinan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header h4">
                        Bendahara
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name_pimpinan"
                                    value="{{ $lembaga->pengurus[2]->name }}" disabled required>
                                @error('name_pimpinan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_pimpinan"
                                    value="{{ $lembaga->pengurus[2]->email }}" disabled required>
                                @error('email_pimpinan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nik"
                                    value="{{ $lembaga->pengurus[2]->nik }}" disabled required>
                                @error('nik')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="{{ $lembaga->pengurus[2]->no_hp }}" disabled required>
                                @error('no_hp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="scan_ktp"
                                    value="{{ $lembaga->pengurus[2]->scan_ktp }}" disabled required>
                                @error('scan_ktp')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" name="alamat_pimpinan" disabled required>{{ $lembaga->pengurus[2]->alamat }}</textarea>
                            @error('alamat_pimpinan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileModalLabel">Preview File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" id="file-preview">
                        <!-- Preview file akan dimasukkan di sini -->
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@push('scripts')
    <script>
        // $(document).ready(function() {
        //     $('.view-file').on('click', function() {
        //         var filePath = $(this).data('path');
        //         var extension = filePath.split('.').pop().toLowerCase();
        //         var previewHtml = '';

        //         if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
        //             previewHtml = '<img src="' + filePath + '" class="img-fluid" alt="File Image">';
        //         } else if (extension === 'pdf') {
        //             previewHtml = '<embed src="' + filePath +
        //                 '" type="application/pdf" width="100%" height="750px">';
        //         } else {
        //             previewHtml = '<p>File tidak dapat dipreview. <a href="' + filePath +
        //                 '" target="_blank">Download di sini</a>.</p>';
        //         }

        //         $('#file-preview').html(previewHtml);
        //         $('#fileModal').modal('show');
        //     });
        // });
    </script>
@endpush
