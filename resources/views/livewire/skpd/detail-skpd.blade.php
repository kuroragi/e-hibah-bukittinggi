<div>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Detail SKPD</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('skpd') }}">SKPD</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('components.partials._page_notification')


    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="pill" href="#data_profil" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Profil SKPD</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="pill" href="#data_nphd" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data TTD NPHD</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="pill" href="#data_urusan" role="tab"
                        aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Urusan</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="pill" href="#data_perhatian" role="tab"
                        aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Menjadi Perhatian di NPHD</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div wire:ignore.self class="tab-pane fade" id="data_profil" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h4>{{ ucwords($skpd->name) }}</h4>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td width="200px" class="align-top">Deskripsi</td>
                            <td class="align-top">:</td>
                            <td>{{ $skpd->deskripsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="align-top">Alamat</td>
                            <td class="align-top">:</td>
                            <td>{{ $skpd->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="align-top">Alamat Email</td>
                            <td class="align-top">:</td>
                            <td>{{ $skpd->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="align-top">telp/Hp</td>
                            <td class="align-top">:</td>
                            <td>{{ $skpd->telp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="align-top">Fax</td>
                            <td class="align-top">:</td>
                            <td>{{ $skpd->fax ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        <div wire:ignore.self class="tab-pane fade" id="data_nphd" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-light">
                    <h4>Data Pimpinan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_pimpinan" class="form-label">Nama</label>
                                <input wire:model='nama_pimpinan' type="text" id="nama_pimpinan"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nip_pimpinan" class="form-label">NIP</label>
                                <input wire:model='nip_pimpinan' type="text" id="nip_pimpinan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="alamat_pimpinan" class="form-label">Alamat</label>
                                <textarea wire:model='alamat_pimpinan' id="alamat_pimpinan" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="email_pimpinan" class="form-label">Email</label>
                                <input wire:model='email_pimpinan' type="email" id="email_pimpinan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="jabatan_pimpinan" class="form-label">Nama Jabatan</label>
                                <input wire:model='jabatan_pimpinan' type="text" id="jabatan_pimpinan"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="golongan_pimpinan" class="form-label">Kelompok jabatan dan
                                    Golongan</label>
                                <input wire:model='golongan_pimpinan' type="text" id="golongan_pimpinan"
                                    class="form-control" placeholder="Pembina Utama Muda - IV/c">
                            </div>
                            <div class="mb-3">
                                <label for="hp_pimpinan" class="form-label">Hp/WA</label>
                                <input wire:model='hp_pimpinan' type="text" id="hp_pimpinan"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-light">
                    <h4>Data Saksi</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="nama_sekretaris" class="form-label">Nama Sekretaris</label>
                                <input wire:model='nama_sekretaris' type="text" id="nama_sekretaris"
                                    class="form-control">
                            </div>
                            @foreach ($urusans as $key => $urusan)
                                <div class="mb-3">
                                    <label for="nama_sekretaris" class="form-label">Nama Kepalan Urusan
                                        {{ $urusan['nama_urusan'] }}</label>
                                    <input wire:model='urusans.{{ $key }}.kepala_urusan' type="text"
                                        id="nama_sekretaris" class="form-control">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button wire:click='simpan_pimpinan' class="btn btn-primary w-100">Simpan Data
                                Saksi</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div wire:ignore.self class="tab-pane fade" id="data_perhatian" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-light">
                    <h4>Hal-hal yang harus menjadi Perhatian Dalam NPHD</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($perhatian_nphd as $key => $item)
                                <div class="mb-3">
                                    <div class="mb-1 w-100 d-flex jutify-content-between">
                                        <label for="perhatian_nphd_{{ $loop->iteration }}" class="form-label">Uraian -
                                            {{ $loop->iteration }}</label>
                                        <button wire:click='hapusPerhatian({{ $key }})'
                                            class="btn btn-sm btn-danger ms-auto">Hapus Uraian -
                                            {{ $loop->iteration }}</button>
                                    </div>
                                    <div class="input-group">
                                        <textarea wire:model='perhatian_nphd.{{ $key }}.uraian' id="perhatian_nphd_{{ $loop->iteration }}"
                                            class="form-control" rows="3"></textarea>
                                        <select wire:model='perhatian_nphd.{{ $key }}.urusan'
                                            class="form-select" id="perhatian_nphd_{{ $loop->iteration }}_urusan">
                                            <option value="0">Semua Urusan</option>
                                            @foreach ($urusans as $key2 => $urusan)
                                                <option value="{{ $urusan['id'] }}">{{ $urusan['nama_urusan'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <button wire:click='previewPerhatian' class="btn btn-info me-3" data-bs-toggle="modal"
                                data-bs-target="#preview-modal"><i class="bi bi-eye"></i>
                                Preview Klausul
                                Perhatian</button>
                            <button wire:click='tambahPerhatian' class="btn btn-primary">Tambah Uraian</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button wire:click='updatePerhatian' class="btn btn-primary w-100">Simpan Perubahan
                                Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div wire:ignore.self class="modal fade" id="preview-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rabModalLabel">Tampilan Klausul Yang menjadi Perhatian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Table Input -->
                        <div class="document-preview p-4 shadow-sm">
                            <p class="no-indent mb-3">PIHAK PERTAMA dan PIHAK KEDUA dengan mendasarkan dan
                                memperhatikan hal sebagai
                                berikut:
                            </p>
                            <ol class="mb-3">
                                @foreach ($perhatian_nphd as $key => $item)
                                    <li>
                                        {{ $item['uraian'] }} @if (!$item['urusan'] == 0)
                                            <strong>- khusus untuk urusan
                                                {{ collect($urusans)->where('id', $item['urusan'])->first()['nama_urusan'] ?? '-' }}</strong>
                                        @endif
                                    </li>
                                @endforeach
                                <li><i>dilanjutkan dengan klausul dari lembaga penerima hibah</i> <span
                                        class="text-danger">*</span></li>
                            </ol>
                        </div>

                        <!-- Tombol Simpan Perubahan -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="tab-pane fade show active" id="data_urusan" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-light">
                    <h4>Konfigurasi data Urusan</h4>
                </div>
                <div class="card-body">
                    @foreach ($urusans as $k1 => $urusan)
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="d-inline">
                                    <span class="mb-3 h3">Urusan {{ $urusan['nama_urusan'] }} Tentang Hibah</span>
                                    <button wire:click='tambahKegiatan({{ $k1 }})'
                                        class="btn btn-primary btn-sm ms-3">Tambah kegiatan</button>
                                </div>
                                @foreach ($urusan['kegiatan'] as $k2 => $kegiatan)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label
                                                    for="kegiatan_{{ $urusan['nama_urusan'] }}_ke_{{ $k1 + 1 }}"
                                                    class="form-label">Nama Kegiatan</label>
                                                <div class="input-group">
                                                    <input
                                                        wire:model='urusans.{{ $k1 }}.kegiatan.{{ $k2 }}.nama_kegiatan'
                                                        type="text"
                                                        id="kegiatan_{{ $urusan['nama_urusan'] }}_ke_{{ $k1 + 1 }}"
                                                        class="form-control">
                                                    <button
                                                        wire:click='tambahSubkegiatan({{ $k1 }}, {{ $k2 }})'
                                                        class="btn btn-primary btn-s">Tambah
                                                        Subkegiatan</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($kegiatan['sub_kegiatan'] as $k3 => $sub_kegiatan)
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label
                                                        for="sub_kegiatan_{{ $kegiatan['nama_kegiatan'] }}_ke_{{ $k3 + 1 }}"
                                                        class="form-label">Nama Subkegiatan</label>
                                                    <div class="input-group">
                                                        <input
                                                            wire:model='urusans.{{ $k1 }}.kegiatan.{{ $k2 }}.sub_kegiatan.{{ $k3 }}.nama_sub_kegiatan'
                                                            type="text"
                                                            id="sub_kegiatan_{{ $kegiatan['nama_kegiatan'] }}_ke_{{ $k3 + 1 }}"
                                                            class="form-control">
                                                        <button
                                                            wire:click='tambahRekening({{ $k1 }}, {{ $k2 }}, {{ $k3 }})'
                                                            class="btn btn-sm btn-primary">Tambah
                                                            Rekening</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div>
                                                        <label
                                                            for="rekening_anggaran_{{ $sub_kegiatan['nama_sub_kegiatan'] }}"
                                                            class="form-label">Rekening Anggaran</label>

                                                    </div>
                                                    @foreach ($sub_kegiatan['rekening_anggaran'] as $k4 => $rekening)
                                                        <div class="input-group mb-3">
                                                            <input
                                                                wire:model='urusans.{{ $k1 }}.kegiatan.{{ $k2 }}.sub_kegiatan.{{ $k3 }}.rekening_anggaran.{{ $k4 }}.rekening'
                                                                type="text" class="form-control">
                                                            <button class="btn btn-danger btn-sm"><i
                                                                    class="bi bi-trash"></i></button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <hr class="mb-3">
                    @endforeach
                    <div class="row">
                        <div class="col-12">
                            <button wire:click='updateUrusan' class="btn btn-primary w-100">Simpan Perubahan
                                Konfigurasi Urusan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('style')
    <style>
        .document-preview {
            background: white;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 40px 60px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            font-family: "Times New Roman", serif;
            font-size: 15px;
            line-height: 1.6;
        }
    </style>
@endpush
