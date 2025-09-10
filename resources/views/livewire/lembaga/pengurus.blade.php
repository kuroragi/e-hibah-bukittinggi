<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Form Pendukung Lembaga</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('lembaga.admin', ['id_lembaga' => $id_lembaga]) }}">Lembaga</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pengurus Lembaga</li>
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

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            Pimpinan Badan/ Lembaga atau Sebutan Lainnya
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.0.name'
                        value="{{ old('name_pimpinan') }}" required>
                    @error('name_pimpinan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" wire:model='pengurus.0.email'
                        value="{{ old('email_pimpinan') }}" required>
                    @error('email_pimpinan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.0.nik' value="{{ old('nik') }}"
                        required>
                    @error('nik')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.0.no_hp' value="{{ old('no_hp') }}"
                        required>
                    @error('no_hp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" wire:model='pengurus.0.scan_ktp'
                        value="{{ old('scan_ktp') }}" required>
                    @if (!empty($pengurus[0]['scan_ktp']))
                        <div class="mt-3">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($pengurus[0]['scan_ktp']) }}">Lihat
                                Photo</button>
                        </div>
                    @endif
                    @error('scan_ktp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="2" wire:model='pengurus.0.alamat' required>{{ old('alamat_pimpinan') }}</textarea>
                @error('alamat_pimpinan')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            Sekretaris
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.1.name'
                        value="{{ old('name_pimpinan') }}" required>
                    @error('name_pimpinan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" wire:model='pengurus.1.email'
                        value="{{ old('email_pimpinan') }}" required>
                    @error('email_pimpinan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.1.nik'
                        value="{{ old('nik') }}" required>
                    @error('nik')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.1.no_hp'
                        value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" wire:model='pengurus.1.scan_ktp'
                        value="{{ old('scan_ktp') }}" required>
                    @if (!empty($pengurus[1]['scan_ktp']))
                        <div class="mt-3">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($pengurus[1]['scan_ktp']) }}">Lihat
                                Photo</button>
                        </div>
                    @endif
                    @error('scan_ktp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="2" wire:model='pengurus.1.alamat'></textarea>
                @error('alamat_pimpinan')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            Bendahara
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.2.name'
                        value="{{ old('name_pimpinan') }}" required>
                    @error('name_pimpinan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" wire:model='pengurus.2.email'
                        value="{{ old('email_pimpinan') }}" required>
                    @error('email_pimpinan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.2.nik'
                        value="{{ old('nik') }}" required>
                    @error('nik')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. Telp/HP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model='pengurus.2.no_hp'
                        value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Scan KTP <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" wire:model='pengurus.2.scan_ktp'
                        value="{{ old('scan_ktp') }}" required>
                    @if (!empty($pengurus[2]['scan_ktp']))
                        <div class="mt-3">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($pengurus[2]['scan_ktp']) }}">Lihat
                                Photo</button>
                        </div>
                    @endif
                    @error('scan_ktp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="2" wire:model='pengurus.2.alamat'></textarea>
                @error('alamat_pimpinan')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button wire:click='store()' class="btn btn-primary w-100">Simpan</button>
        </div>
    </div>
</div>
