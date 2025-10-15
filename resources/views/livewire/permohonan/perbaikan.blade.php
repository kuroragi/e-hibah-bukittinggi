<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Perbaikan</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan') }}">Permohonan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Perbaikan</li>
                </ol>
            </nav>
        </div>
        {{-- <div class="ms-auto">
            <a href="{{ $this->checkRab() ? 'javascript:' : route('permohonan') }}" @if ($this->checkRab()) title="RAB
                Belum Diperbarui" @endif>
                <button class="btn btn-primary" @disabled($this->checkRab())>
                    Back
                </button>
            </a>
        </div> --}}
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
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" wire:model="tanggal_proposal" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Proposal <span class="text-danger">*</span></label>
                    <input type="text" wire:model="judul_proposal" class="form-control">
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Scan Proposal Baru <span class="text-danger">*</span></label>
                            <input type="file" wire:model="file_proposal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($permohonan->file_proposal) }}">Lihat
                                Dokumen Lama</button>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Scan RAB Baru <span class="text-danger">*</span></label>
                                <input type="file" wire:model="file_rab" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#fileModal"
                                    data-file-url="{{ Storage::url($permohonan->pendukung?->file_rab) }}">Lihat
                                    Dokumen lama</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="card">
            <div class="card-body">

                @if (session()->has('warning_rab'))
                    <div class="alert alert-secondary" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <h3 class="font-semibold mt-6 mb-2">RAB</h3>
                <div class="row mb-4">

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label for="totalPengajuan" class="form-label">Total Pengajuan <span
                                    class="text-danger">*</span></label>
                            <input wire:model.change='nominal_rab' type="number" class="form-control"
                                id="totalPengajuan" placeholder="Masukkan total pengajuan">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nominalRAB" class="form-label">Nominal RAB <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model='total_kegiatan' class="form-control" id="nominalRAB"
                                placeholder="Masukkan nominal RAB" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nominalRAB" class="form-label">&nbsp;</label><br>
                            <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#update_rab_modal">Update RAB
                                Kegiatan</button>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatan_rab as $item)
                                    <tr>
                                        <td class="text-start">{{ $item['nama_kegiatan'] }}</td>
                                        <td class="d-flex justify-content-between"><span>Rp.</span>
                                            {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid">
                        <button wire:click='saveRevisi' class="btn btn-primary" @disabled($this->checkRab())>Simpan
                            Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fileModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center" id="modalFileContent">
                        <p>Memuat konten...</p>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="update_rab_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rabModalLabel">Tambah Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Tombol Tambah Rincian -->
                        <div class="d-flex justify-content-end mb-3">
                            <button wire:click='tambahKegiatan' class="btn btn-primary">Tambah Kegiatan</button>
                        </div>

                        <!-- Table Input -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Sutotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris Highlight (opsional, bisa dihapus kalau tidak diperlukan) -->
                                    @foreach ($kegiatan_rab as $k1 => $item)
                                        <!-- Baris Highlight (opsional, bisa dihapus kalau tidak diperlukan) -->
                                        <tr>
                                            <td><input wire:model='kegiatan_rab.{{ $k1 }}.nama_kegiatan'
                                                    type="text" class="form-control" placeholder="Nama Kegiatan">
                                            </td>
                                            <td><input wire:model='kegiatan_rab.{{ $k1 }}.subtotal'
                                                    type="text" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                {{-- <button wire:click='tambahRincian({{ $k1 }})'
                                                    class="btn btn-sm btn-primary"><i
                                                        class="bi bi-plus-lg"></i></button> --}}
                                                <button wire:click='deleteFormkegiatan({{ $k1 }})'
                                                    class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                        {{-- @foreach ($item['rincian'] as $k2 => $child)
                                            <tr>
                                                <td><input type="text" class="form-control"
                                                        wire:model="kegiatan_rab.{{ $k1 }}.rincian.{{ $k2 }}.kegiatan">
                                                </td>
                                                <td><input type="number" class="form-control"
                                                        wire:model.change="kegiatan_rab.{{ $k1 }}.rincian.{{ $k2 }}.volume">
                                                </td>
                                                <td>
                                                    <div wire:ignore x-data x-init="() => {
                                                        let select_satuan = $($el).find('#select_satuan_{{ $k1 }}{{ $k2 }}');
                                                        select_satuan.select2({
                                                            dropdownAutoWidth: true,
                                                            width: '100%',
                                                            dropdownParent: $('#create_modal') // pastikan ID-nya sesuai
                                                        });
                                                    
                                                        select_satuan.on('change', function() {
                                                            $wire.set('kegiatan_rab.{{ $k1 }}.rincian.{{ $k2 }}.satuan', this.value);
                                                        });
                                                    
                                                        // optional sync back from Livewire
                                                        $watch('value', value => select_satuan.val(value).trigger('change'));
                                                    }">
                                                        <select class="form-select"
                                                            id="select_satuan_{{ $k1 }}{{ $k2 }}">
                                                            <option value="">Pilih Satuan</option>
                                                            @foreach ($satuans as $satuan)
                                                                <option value="{{ $satuan->id }}">
                                                                    {{ $satuan->name }}
                                                                </option>
                                                            @endforeach
                                                            <!-- Tambah satuan lain sesuai kebutuhan -->
                                                        </select>
                                                    </div>
                                                </td>
                                                <td><input type="number" class="form-control"
                                                        wire:model.change="kegiatan_rab.{{ $k1 }}.rincian.{{ $k2 }}.harga_satuan">
                                                </td>
                                                <td class="text-end">
                                                    <input type="hidden"
                                                        wire:model='kegiatan_rab.{{ $k1 }}.rincian.{{ $k2 }}.subtotal'>
                                                    Rp {{ number_format($this->getSubtotal($k1, $k2), 0, ',', '.') }}
                                                </td>
                                                <td class="text-start">
                                                    <button type="button"
                                                        wire:click="deleteRincian({{ $kegiatan_rab[$k1]['rincian'][$k2]['id_rincian'] }})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tombol Simpan Perubahan -->
                        <div class="d-flex justify-content-end">
                            <button wire:click='update_rab' type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileModal = document.getElementById('fileModal');
            const modalContent = document.getElementById('modalFileContent');

            fileModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const fileUrl = button.getAttribute('data-file-url');
                const extension = fileUrl.split('.').pop().toLowerCase();

                // Reset isi
                modalContent.innerHTML = '<p>Memuat konten...</p>';

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                    modalContent.innerHTML =
                        `<img src="${fileUrl}" alt="Gambar" class="img-fluid rounded shadow">`;
                } else if (extension === 'pdf') {
                    modalContent.innerHTML =
                        `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
                } else {
                    modalContent.innerHTML = `<p class="text-danger">Jenis file tidak didukung.</p>`;
                }
            });

            Livewire.on('close-modal', function() {
                $("#update_rab_modal").modal('hide');
            })
        });
    </script>
@endpush
