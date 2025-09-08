<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Formulir Inisiasi Badan/Lembaga</div>
        <!--end breadcrumb-->
    </div>
    <div class="col col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Form Pendaftaran Lembaga
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Badan/ Lembaga atau Sebutan Lainnya <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model='name_lembaga'
                                wire:model='name_lembaga' required>
                            @error('nama_lembaga')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Singkatan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model='acronym' required>
                            @error('acronym')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" wire:model='email' id="email" wire:model='email'
                            required>
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">No. Telp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model='phone' id="phone" wire:model='phone'
                            required>
                        @error('phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="search" class="form-label">SKPD</label>
                            <select wire:model.live='id_skpd' class="form-control">
                                <option value="">--- Pilih SKPD ---</option>
                                @foreach ($skpd as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="search" class="form-label">Urusan</label>
                            <select wire:model='id_urusan' class="form-control">
                                <option value="">--- Pilih Urusan ---</option>
                                @foreach ($urusan as $key => $item)
                                    <option value="{{ $item['id'] }}">{{ $item['nama_urusan'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="propinsi" class="form-label">Propinsi <span class="text-danger">*</span></label>
                    <select wire:model.live='propinsi' class="form-select" id="propinsi">
                        <option selected>Pilih Propinsi</option>
                        <!-- Tambahkan Propinsi -->
                        @foreach ($propinsis as $item)
                            <option value="{{ $item->id }}">{{ ucwords($item->name) }}</option>
                        @endforeach
                    </select>
                    @error('propinsi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                    <select wire:model.live='kab_kota' class="form-select" id="kota">
                        <option selected>Pilih Kota/Kabupaten</option>
                        <!-- Tambahkan Kota -->
                        @foreach ($kabkotas as $item)
                            <option value="{{ $item['id'] }}">{{ ucwords($item['name']) }}</option>
                        @endforeach
                    </select>
                    @error('kota')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select wire:model.live='kecamatan' class="form-select" id="kecamatan">
                            <option selected>Pilih Kecamatan</option>
                            @foreach ($kecamatans as $item)
                                <option value="{{ $item['id'] }}">{{ ucwords($item['name']) }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kelurahan" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                        <select wire:model.live='kelurahan' class="form-select" id="kecamatan">
                            <option selected>Pilihan Keluruhan</option>
                            @foreach ($kelurahans as $item)
                                <option value="{{ $item['id'] }}">{{ ucwords($item['name']) }}</option>
                            @endforeach
                        </select>
                        @error('kelurahan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea wire:model='alamat' class="form-control" name="alamat" id="alamat" rows="2" required></textarea>
                    @error('alamat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Photo Lembaga</label>
                    <input type="file" wire:model='photo' id="photo" class="form-control">
                    @error('photo')
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
                    <input type="text" class="form-control" name="npwp" id="npwp" wire:model='npwp'
                        required>
                    @error('npwp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Akta Kumham -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Akta Kumham/ SK Lembaga <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_akta_kumham" wire:model='no_akta_kumham'
                            required>
                        @error('no_akta_kumham')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_akta_kumham"
                            wire:model='date_akta_kumham' required>
                        @error('date_akta_kumham')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="file_akta_kumham"
                            wire:model='file_akta_kumham' required>
                        @error('file_akta_kumham')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Surat Domisili -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Surat Domisili <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_domisili" wire:model='no_domisili'
                            required>
                        @error('no_domisili')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_domisili" wire:model='date_domisili'
                            required>
                        @error('date_domisili')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="file_domisili" wire:model='file_domisili'
                            required>
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
                        <input type="text" class="form-control" name="no_operasional" wire:model='no_operasional'
                            required>
                        @error('no_operasional')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_operasional"
                            wire:model='date_operasional' required>
                        @error('date_operasional')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="file_operasional"
                            wire:model='file_operasional' required>
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
                        <input type="text" class="form-control" name="no_pernyataan" wire:model='no_pernyataan'
                            required>
                        @error('no_pernyataan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_pernyataan"
                            wire:model='date_pernyataan' required>
                        @error('date_pernyataan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Scan Dokumen <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="file_pernyataan"
                            wire:model='file_pernyataan' required>
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
                        <input type="text" class="form-control" wire:model='name_pimpinan' required>
                        @error('name_pimpinan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" wire:model='email_pimpinan' required>
                        @error('email_pimpinan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model='nik' required>
                        @error('nik')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model='no_hp' required>
                        @error('no_hp')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                        <input type="file" wire:model='scan_ktp' class="form-control" required>
                        @error('scan_ktp')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea wire:model='alamat_pimpinan' class="form-control" rows="2" name="alamat_pimpinan" required></textarea>
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

                <button wire:click='store' type="submit" class="btn btn-primary w-100">Simpan</button>
            </div>
        </div>
    </div>
</div>
