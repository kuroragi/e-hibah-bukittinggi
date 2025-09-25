<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Form Pengajuan Permohonan</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan') }}">Permohonan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Permohonan</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('error'))
        {
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        }
    @endif

    <div class="row">
        <div class="col-12">
            <form wire:submit.prevent="store" enctype="multipart/form-data" class="space-y-8">
                {{-- Usulah APBD --}}
                <div class="mb-4">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-label">Usulan APBD</label>
                            <input type="text" wire:model="usulan_apbd" class="form-control"
                                placeholder="{{ date('Y') + 1 }}">
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
                                            <label class="form-label">No Surat <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" wire:model="no_mohon" class="form-control">
                                            @error('no_mohon')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Perihal Surat <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" wire:model="perihal_mohon" class="form-control">
                                            @error('perihal_mohon')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Permohonan <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="bi bi-calendar"></i></span>
                                                <input type="date" wire:model="tanggal_mohon" class="form-control">
                                                @error('tanggal_mohon')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Scan Permohonan <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" wire:model="file_mohon" class="form-control">
                                            @error('file_mohon')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
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
                                        <input type="text" wire:model="no_proposal" class="form-control">
                                        @error('no_proposal')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pengajuan <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                            <input type="date" wire:model="tanggal_proposal" class="form-control">
                                            @error('tanggal_proposal')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Judul Proposal <span class="text-danger">*</span></label>
                                <input type="text" wire:model="title" class="form-control">
                                @error('title')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SKPD <span class="text-danger">*</span></label>
                                <select wire:model="id_skpd" id="id_skpd" class="form-control" disabled>
                                    <option value="">-- Pilih SKPD --</option>
                                    @foreach ($skpds as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_skpd')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Urusan <span class="text-danger">*</span></label>
                                <select wire:model="urusan" id="urusan" class="form-control" disabled>
                                    <option value="">-- Pilih Urusan --</option>
                                    @foreach ($urusans as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_urusan }}</option>
                                    @endforeach
                                </select>
                                @error('urusan')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Awal <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                            <input type="date" wire:model="awal_laksana" class="form-control">
                                            @error('awal_laksana')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Akhir <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                            <input type="date" wire:model="akhir_laksana" class="form-control">
                                            @error('akhir_laksana')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Scan Proposal <span class="text-danger">*</span></label>
                                <input type="file" wire:model="file_proposal" class="form-control">
                                @error('file_proposal')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
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
                                <textarea wire:model="latar_belakang" class="form-control" rows="3"></textarea>
                                @error('latar_belakang')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Maksud Tujuan</label>
                                <textarea wire:model="maksud_tujuan" class="form-control" rows="3"></textarea>
                                @error('maksud_tujuan')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea wire:model="keterangan" class="form-control" rows="3"></textarea>
                                @error('keterangan')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-100">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $("#id_skpd").on("change", function() {
            Livewire.dispatch("id_skpd_updated", {
                data: $(this).val()
            });
        })
    </script>
@endpush
