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
                    <li class="breadcrumb-item active" aria-current="page">Pendukung Lembaga</li>
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

    <div class="card p-3 mb-3">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Surat Domisili *</label>
                <input type="text" wire:model.defer="no_domisili" class="form-control"
                    value="{{ old('no_domisili') }}">
            </div>
            <div class="col-md-4">
                <label>Tanggal *</label>
                <input type="date" wire:model.defer="date_domisili" class="form-control"
                    value="{{ old('date_domisili') }}">
            </div>
            <div class="col-md-4">
                <label>Scan Dokumen *</label>
                <input type="file" wire:model="file_domisili" class="form-control">
                <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#fileModal"
                    data-file-url="{{ Storage::url($file_domisili) }}">Lihat Dokumen Surat Domisili</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Izin Operasional / Tanda Daftar Lembaga *</label>
                <input type="text" wire:model.defer="no_operasional" class="form-control"
                    value="{{ old('no_operasional') }}">
            </div>
            <div class="col-md-4">
                <label>Tanggal *</label>
                <input type="date" wire:model.defer="date_operasional" class="form-control"
                    value="{{ old('date_operasional') }}">
            </div>
            <div class="col-md-4">
                <label>Scan Dokumen *</label>
                <input type="file" wire:model="file_operasional" class="form-control">
                <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#fileModal"
                    data-file-url="{{ Storage::url($file_operasional) }}">Lihat Dokumen Surat Operasional</button>
            </div>
        </div>
    </div>

    {{-- Card Data Bank --}}
    <div class="card p-3">
        <h5>Data Bank</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nama Bank *</label>
                <select wire:model.defer="id_bank" class="form-control">
                    <option value="">Pilih Bank</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->acronym }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Atas Nama *</label>
                <input type="text" wire:model.defer="atas_nama" class="form-control" value="{{ old('atas_nama') }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nomor Rekening *</label>
                <input type="text" wire:model.defer="no_rek" class="form-control" value="{{ old('no_rek') }}">
            </div>
            <div class="col-md-6">
                <label>Scan Buku Rekening *</label>
                <input type="file" wire:model="photo_rek" class="form-control">
                @error('photo_rek')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
                @if ($photo_rek)
                    <div class="mt-3">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#fileModal" data-file-url="{{ Storage::url($photo_rek) }}">Lihat
                            Photo</button>
                    </div>
                @endif
            </div>
        </div>

        <button wire:click="update" class="btn btn-primary w-100">Update</button>
    </div>
</div>
