<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Cek Permohonan {{ $edit_state }}</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan') }}">Permohonan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ $this->checkRab() ? 'javascript:' : route('permohonan') }}"
                @if ($this->checkRab()) title="RAB Belum Diperbarui" @endif>
                <button class="btn btn-primary" @disabled($this->checkRab())>
                    Back
                </button>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" wire:click='updateEditState({{ ' lembaga' }})' role="presentation">
                    <a wire:ignore.self class="nav-link @if ($edit_state == 'lembaga') active @endif"
                        data-bs-toggle="pill" href="#data_lembaga" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Lembaga</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" wire:click='updateEditState({{ ' proposal' }})' role="presentation">
                    <a wire:ignore.self class="nav-link @if ($edit_state == 'proposal') active @endif"
                        data-bs-toggle="pill" href="#data_proposal" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Proposal</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" wire:click='updateEditState({{ ' rab' }})' role="presentation">
                    <a wire:ignore.self class="nav-link @if ($edit_state == 'rab') active @endif"
                        data-bs-toggle="pill" href="#data_rab" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Rab</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" wire:click='updateEditState({{ ' pendukung' }})' role="presentation">
                    <a wire:ignore.self class="nav-link @if ($edit_state == 'pendukung') active @endif"
                        data-bs-toggle="pill" href="#data_pendukung" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">Data Pendukung</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div wire:ignore.self class="tab-pane fade  @if ($edit_state == 'lembaga') show active @endif"
            id="data_lembaga" role="tabpanel">

            <div class="card">
                <div class="card-body">
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="search" class="form-label">Nama Lembaga</label>
                            <input type="text" class="form-control" value="{{ $permohonan->lembaga->name }}"
                                disabled>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label for="filter" class="form-label">Email</label>
                                    <input type="text" class="form-control" value="{{ $permohonan->lembaga->email }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label for="filter" class="form-label">No. Telp</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">+62</span>
                                        <input type="text" class="form-control"
                                            value="{{ $permohonan->lembaga->phone }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" rows="3" disabled>{{ $permohonan->lembaga->alamat }}"</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="tab-pane fade @if ($edit_state == 'proposal') show active @endif"
            id="data_proposal" role="tabpanel">
            @if (session()->has('proposal_error'))
                <div class="mb-4">
                    <div class="alert alert-success">{{ session('message') }}</div>
                </div>
            @endif
            {{-- Usulah APBD --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <label class="form-label">Usulan APBD</label>
                        <input type="text" wire:model="usulan_apbd" class="form-control" placeholder="2025">
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
                                        <label class="form-label">No Surat <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="no_mohon" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Perihal Surat <span
                                                class="text-danger">*</span></label>
                                        <input type="text" wire:model="perihal_mohon" class="form-control">
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
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scan Permohonan <span
                                                class="text-danger">*</span></label>
                                        <input type="file" wire:model="file_mohon" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#fileModal"
                                            data-file-url="{{ Storage::url($permohonan->file_mohon) }}">Lihat
                                            Dokumen</button>
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
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengajuan <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" wire:model="tanggal_proposal" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Proposal <span class="text-danger">*</span></label>
                            <input type="text" wire:model="title" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKPD <span class="text-danger">*</span></label>
                            <select wire:model="id_skpd" id="id_skpd" class="form-control">
                                <option value="">-- Pilih SKPD --</option>
                                @foreach ($skpds as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urusan <span class="text-danger">*</span></label>
                            <select wire:model="urusan" id="urusan" class="form-control">
                                <option value="">-- Pilih Urusan --</option>
                                @foreach ($urusans as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_urusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Awal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" wire:model="awal_laksana" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Akhir <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" wire:model="akhir_laksana" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Scan Proposal <span class="text-danger">*</span></label>
                            <input type="file" wire:model="file_proposal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#fileModal"
                                data-file-url="{{ Storage::url($permohonan->file_proposal) }}">Lihat
                                Dokumen</button>
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
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maksud Tujuan</label>
                            <textarea wire:model="maksud_tujuan" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea wire:model="keterangan" class="form-control" rows="3"></textarea>
                        </div>

                        <div>
                            <button wire:click='update_proposal' type="submit" class="btn btn-warning w-100">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="tab-pane fade  @if ($edit_state == 'rab') show active @endif"
            id="data_rab" role="tabpanel">
            <div class="card">
                <div class="card-body">

                    @if (session()->has('warning_rab'))
                        <div class="alert alert-secondary" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
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
                                data-bs-target="#update_rab_modal">Update
                                Kegiatan dan Rincian</button>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Rincian Kegiatan</th>
                                    <th>Volume</th>
                                    <th>Satuan<br>(Liter, KD, dan Sebagainya)</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatans as $kegiatan)
                                    <tr class="bg-warning">
                                        <td colspan="4" class="text-start">{{ $kegiatan->nama_kegiatan }}</td>
                                        <td class="text-end">
                                            {{ number_format(
                                                collect($kegiatan->rincian)->pluck('subtotal')->filter(fn($val) => is_numeric($val))->sum(),
                                                0,
                                                ',',
                                                '.',
                                            ) }}
                                        </td>
                                    </tr>
                                    @foreach ($kegiatan->rincian as $rincian)
                                        <tr class="">
                                            <td class="text-start">{{ $rincian->keterangan }}</td>
                                            <td>{{ $rincian->volume }}</td>
                                            <td class="text-start">{{ $rincian->satuan->name }}</td>
                                            <td class="text-end">{{ number_format($rincian->harga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($rincian->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid">
                        <button wire:click='saveRab' class="btn btn-primary" @disabled($this->checkRab())>Simpan
                            Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="tab-pane fade  @if ($edit_state == 'pendukung') show active @endif"
            id="data_pendukung" role="tabpanel">

            <div class="card">
                <div class="card-body">
                    <h3 class="font-semibold mb-2">Surat Permohonan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Surat Pernyataan Pertanggung JAwab <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_pernyataan_tanggung_jawab"
                                        class="form-control mb-3">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#fileModal"
                                        data-file-url="{{ Storage::url($pendukung->file_pernyataan_tanggung_jawab) }}">Lihat
                                        Dokumen</button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berkas RAB <span class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_rab" class="form-control mb-3">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#fileModal"
                                        data-file-url="{{ Storage::url($pendukung->file_rab) }}">Lihat
                                        Dokumen</button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Struktur Pengurus <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="struktur_pengurus" class="form-control mb-3">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#fileModal"
                                        data-file-url="{{ Storage::url($pendukung->struktur_pengurus) }}">Lihat
                                        Dokumen</button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Saldo Akhir Rekening Bank <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="saldo_akhir_rek" class="form-control mb-3">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#fileModal"
                                        data-file-url="{{ Storage::url($pendukung->saldo_akhir_rek) }}">Lihat
                                        Dokumen</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="font-semibold mb-2">Surat Permohonan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Surat Pernyataan Tidak Tumpang Tindih <span
                                            class="text-danger">*</span></label>
                                    <input type="text" wire:model="no_tidak_tumpang_tindih" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" wire:model="tanggal_tidak_tumpang_tindih"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Surat Pernyataan <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_tidak_tumpang_tindih"
                                        class="form-control mb-3">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#fileModal"
                                        data-file-url="{{ Storage::url($pendukung->file_tidak_tumpang_tindih) }}">Lihat
                                        Dokumen</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button wire:click='update_pendukung'
                                    class="btn btn-warning form-control">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="update_rab_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="rabModalLabel">Tambah Kegiatan dan Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <th>Rencana Rincian Kegiatan</th>
                                    <th>Volume</th>
                                    <th>Satuan (liter, KD, dan Sebagainya)</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris Highlight (opsional, bisa dihapus kalau tidak diperlukan) -->
                                @foreach ($kegiatan_rab as $k1 => $item)
                                    <!-- Baris Highlight (opsional, bisa dihapus kalau tidak diperlukan) -->
                                    <tr class="bg-warning">
                                        <td colspan="4"><input
                                                wire:model='kegiatan_rab.{{ $k1 }}.nama_kegiatan'
                                                type="text" class="form-control" placeholder="Nama Kegiatan">
                                        </td>
                                        <td><input wire:model='kegiatan_rab.{{ $k1 }}.total_kegiatan'
                                                type="text" class="form-control" readonly>
                                        </td>
                                        <td class="text-start">
                                            <button wire:click='tambahRincian({{ $k1 }})'
                                                class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i></button>
                                            <button wire:click='deleteKegiatan({{ $item['id_kegiatan'] }})'
                                                class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @foreach ($item['rincian'] as $k2 => $child)
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
                                    @endforeach
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('close-modal', function() {
                $("#update_rab_modal").modal('hide');
            })
        });
    </script>
@endpush
