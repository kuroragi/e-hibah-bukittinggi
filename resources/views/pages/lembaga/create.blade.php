@extends('components.layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Formulir Inisiasi Badan/Lembaga</div>
        <!--end breadcrumb-->
    </div>
    <div class="col col-12">
        <form action="{{ route('lembaga.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Form Pendaftaran Lembaga
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Badan/ Lembaga atau Sebutan Lainnya <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name_lembaga" id="name"
                            value="{{ old('name_lembaga') }}" required>
                        @error('name_lembaga')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">No. Telp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone"
                                value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="propinsi" class="form-label">Propinsi <span class="text-danger">*</span></label>
                        <select class="form-select" id="propinsi">
                            <option selected>Pilih Propinsi</option>
                            <!-- Tambahkan Propinsi -->
                            <option value="1">Sumatera Barat</option>
                        </select>
                        @error('propinsi')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <select class="form-select" id="kota">
                            <option selected>Pilih Kota/Kabupaten</option>
                            <!-- Tambahkan Kota -->
                            <option value="1">Kota Bukittinggi</option>
                        </select>
                        @error('kota')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select class="form-select" id="kecamatan">
                                <option selected>Pilih Kecamatan</option>
                                <option value="1">Mandiangin Koto Selayan</option>
                                <option value="2">Aur Birugo Tigo Baleh</option>
                                <option value="3">Guguk Panjang</option>
                            </select>
                            @error('kecamatan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kelurahan" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kelurahan" id="kelurahan"
                                value="{{ old('kelurahan') }}" required>
                            @error('kelurahan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="2" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    Dokumen Lembaga
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="npwp" class="form-label">No. NPWP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="npwp" id="npwp"
                            value="{{ old('npwp') }}" required>
                        @error('npwp')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Akta Kumham -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Akta Kumham/ SK Lembaga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_akta_kumham"
                                value="{{ old('no_akta_kumham') }}" required>
                            @error('no_akta_kumham')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_akta_kumham"
                                value="{{ old('date_akta_kumham') }}" required>
                            @error('date_akta_kumham')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_akta_kumham"
                                value="{{ old('file_akta_kumham') }}" required>
                            @error('file_akta_kumham')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Surat Domisili -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Surat Domisili <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_domisili"
                                value="{{ old('no_domisili') }}" required>
                            @error('no_domisili')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_domisili"
                                value="{{ old('date_domisili') }}" required>
                            @error('date_domisili')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_domisili"
                                value="{{ old('file_domisili') }}" required>
                            @error('file_domisili')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Izin Operasional -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Izin Operasional/ Tanda Daftar Lembaga <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_operasional"
                                value="{{ old('no_operasional') }}" required>
                            @error('no_operasional')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_operasional"
                                value="{{ old('date_operasional') }}" required>
                            @error('date_operasional')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_operasional"
                                value="{{ old('file_operasional') }}" required>
                            @error('file_operasional')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Surat Pernyataan -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Surat Pernyataan Tidak Tumpang Tindih <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_pernyataan"
                                value="{{ old('no_pernyataan') }}" required>
                            @error('no_pernyataan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_pernyataan"
                                value="{{ old('date_pernyataan') }}" required>
                            @error('date_pernyataan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_pernyataan"
                                value="{{ old('file_pernyataan') }}" required>
                            @error('file_pernyataan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    Pimpinan Badan/ Lembaga atau Sebutan Lainnya
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name_pimpinan"
                                value="{{ old('name_pimpinan') }}" required>
                            @error('name_pimpinan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email_pimpinan"
                                value="{{ old('email_pimpinan') }}" required>
                            @error('email_pimpinan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nik" value="{{ old('nik') }}"
                                required>
                            @error('nik')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp') }}"
                                required>
                            @error('no_hp')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="scan_ktp" value="{{ old('scan_ktp') }}"
                                required>
                            @error('scan_ktp')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="2" name="alamat_pimpinan" required>{{ old('alamat_pimpinan') }}</textarea>
                        @error('alamat_pimpinan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-secondary small">
                        Mohon periksa dan pastikan bahwa semua informasi yang Anda unggah sudah benar.
                        Harap diperhatikan bahwa jika terdapat kesalahan atau ketidaksesuaian pada data atau file yang
                        diunggah,
                        pengajuan hibah Anda berpotensi ditolak. Informasi usulan hibah Anda akan dipublikasikan melalui
                        e-Hibah.
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="agreement" required>
                        <label class="form-check-label" for="agreement">
                            Saya setuju dengan pernyataan di atas
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
        </form>
    </div>


    </div>
@endsection
