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
                    <a class="nav-link active" data-bs-toggle="pill" href="#data_nphd" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data NPHD</div>
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

        <div wire:ignore.self class="tab-pane fade show active" id="data_nphd" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h4>Data Pimpinan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_pimpinan" class="form-label">Nama</label>
                                <input wire:model='nama_pimpinan' type="text" id="nama_pimpinan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nip_pimpinan" class="form-label">NIP</label>
                                <input wire:model='nip_pimpinan' type="text" id="nip_pimpinan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="alamat_pimpinan" class="form-label">Alamat</label>
                                <textarea wire:model='alamat_pimpinan' id="alamat_pimpinan" class="form-control"
                                    rows="3"></textarea>
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
                                <label for="golongan_pimpinan" class="form-label">Kelompok jabatan dan Golongan</label>
                                <input wire:model='golongan_pimpinan' type="text" id="golongan_pimpinan"
                                    class="form-control" placeholder="Pembina Utama Muda - IV/c">
                            </div>
                            <div class="mb-3">
                                <label for="hp_pimpinan" class="form-label">Hp/WA</label>
                                <input wire:model='hp_pimpinan' type="text" id="hp_pimpinan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button wire:click='simpan_pimpinan' class="btn btn-primary w-100">Simpan Data
                                Pimpinan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h4>Data Sekretaris</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_sekretaris" class="form-label">Nama</label>
                                <input wire:model='nama_sekretaris' type="text" id="nama_sekretaris"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nip_sekretaris" class="form-label">NIP</label>
                                <input wire:model='nip_sekretaris' type="text" id="nip_sekretaris" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="alamat_sekretaris" class="form-label">Alamat</label>
                                <textarea wire:model='alamat_sekretaris' id="alamat_sekretaris" class="form-control"
                                    rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="email_sekretaris" class="form-label">Email</label>
                                <input wire:model='email_sekretaris' type="email" id="email_sekretaris"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Nama Jabatan</label>
                                <input wire:model='jabatan' type="text" id="jabatan_sekretaris" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="golongan_sekretaris" class="form-label">Kelompok jabatan dan
                                    Golongan</label>
                                <input wire:model='golongan_sekretaris' type="text" id="golongan_sekretaris"
                                    class="form-control" placeholder="Pembina Utama Muda - IV/c">
                            </div>
                            <div class="mb-3">
                                <label for="hp_sekretaris" class="form-label">Hp/WA</label>
                                <input wire:model='hp_sekretaris' type="text" id="hp_sekretaris" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button wire:click='simpan_sekretaris' class="btn btn-primary w-100">Simpan Data
                                Sekretaris</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>