<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Form Konfigurasi NPHD</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('lembaga.admin', ['id_lembaga' => $lembaga->id]) }}">Lembaga</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Konfigurasi NPHD</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('components.partials._page_notification')

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-light">
            <h3>Data Konfigurasi NPHD</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="nomor_pengukuhan" class="form-label">Nomor Surat Pengukuhan Pimpinan</label>
                        <input wire:model='nomor_pengukuhan' id="nomor_pengukuhan" type="text" class="form-control">
                        @error('nomor_pengukuhan')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tentang_pengukuhan" class="form-label">Tentang</label>
                        <input wire:model='tentang_pengukuhan' id="tentang_pengukuhan" type="text"
                            class="form-control"
                            placeholder="Contoh: Pengukuhan Personalia Pengurus KONI Kota Bukittinggi">
                        @error('tentang_pengukuhan')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="masa_bakti" class="form-label">Masa Bakti</label>
                        <input wire:model='masa_bakti' id="masa_bakti" type="text" class="form-control"
                            placeholder="2025 - 2029">
                        @error('masa_bakti')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="tanggal_pengukuhan" class="form-label">Tanggal Pengukuhan Pimpinan</label>
                        <input wire:model='tanggal_pengukuhan' id="tanggal_pengukuhan" type="date"
                            class="form-control">
                        @error('tanggal_pengukuhan')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="pemberi_amanat" class="form-label">Pemberi Amanat (pada pimpinan)</label>
                        <input wire:model='pemberi_amanat' id="pemberi_amanat" type="text" class="form-control"
                            placeholder="Ketua Umum Provinsi Suamtera Barat">
                        @error('pemberi_amanat')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Pimpinan {{ $lembaga->acronym }} sebagai:</label>
                        <textarea wire:model='deskripsi' id="deskripsi" rows="3" class="form-control"></textarea>
                        @error('deskripsi')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3 d-flex align-center">
                        <h6 class="me-3">Menjadi Perhatian Dalam NPHD</h6>
                        <button wire:click='tambahUraian' class="btn btn-sm btn-primary"><i class="bi bi-plus"></i>
                            Tambah Uraian</button>
                    </div>
                    @foreach ($uraian as $key => $item)
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Uraian - {{ $loop->iteration }}</span>
                                <input wire:model='uraian.{{ $key }}.uraian' type="text"
                                    class="form-control">
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                    @error('uraian')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button wire:click='updateKonfigurasi' class="btn btn-primary w-100">Simpan Perubahan Data</button>
                </div>
            </div>
        </div>
    </div>
</div>
