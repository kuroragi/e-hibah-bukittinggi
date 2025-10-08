<div>
    <div class="card p-4 shadow-sm">
        <h4 class="text-center mb-4">Rencana Anggaran Biaya (RAB)</h4>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label for="totalPengajuan" class="form-label">Total Pengajuan <span class="text-danger">*</span></label>
                <input type="number" class="form-control" wire:model.change='total_pengajuan' id="totalPengajuan"
                    placeholder="Masukkan total pengajuan"
                    value="{{ collect($kegiatans)->flatMap(fn($kegiatan) => $kegiatan)->map(fn($item) => $item['rincian']['subtotal'] ?? 0)->sum() }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="nominalRAB" class="form-label">Nominal RAB <span class="text-danger">*</span></label>
                <input type="text" wire:model='total_kegiatan' class="form-control" id="nominalRAB"
                    placeholder="Masukkan nominal RAB" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="nominalRAB" class="form-label">&nbsp;</label><br>
                <button wire:click='tambahKegiatan' class="btn btn-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#create_modal">Tambah
                    Kegiatan dan Rincian</button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Rincian Kegiatan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatans as $kegiatan)
                        <tr class="bg-warning">
                            <td class="text-start">{{ $kegiatan->nama_kegiatan }}</td>
                            <td class="text-end">
                                {{ number_format(collect($kegiatan->subtotal), 0, ',', '.') }}
                                {{-- {{ number_format(
                                    collect($kegiatan->rincian)->pluck('subtotal')->filter(fn($val) => is_numeric($val))->sum(),
                                    0,
                                    ',',
                                    '.',
                                ) }} --}}
                            </td>
                            <td><button class="btn btn-sm btn-warning"><i
                                        class="bi bi-pencil-square"></i></button><button
                                    wire:click='deleteKegiatan({{ $kegiatan->id }})' class="btn btn-sm btn-danger"><i
                                        class="bi bi-trash"></i></button></td>
                        </tr>
                        {{-- @foreach ($kegiatan->rincian as $rincian)
                    <tr class="">
                        <td class="text-start">{{ $rincian->keterangan }}</td>
                        <td>{{ $rincian->volume }}</td>
                        <td class="text-start">{{ $rincian->satuan->name }}</td>
                        <td class="text-end">{{ number_format($rincian->harga, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($rincian->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach --}}
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-grid">
            @if ($permohonan->id_status == 2)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submit_modal"
                    @disabled($this->checkPengajuan())>Submit</button>
            @endif
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="create_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="rabModalLabel">Tambah Kegiatan</h5>
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
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris Highlight (opsional, bisa dihapus kalau tidak diperlukan) -->
                                @foreach ($kegiatan_rab as $k1 => $item)
                                    <!-- Baris Highlight (opsional, bisa dihapus kalau tidak diperlukan) -->
                                    <tr class="bg-warning">
                                        <td><input wire:model='kegiatan_rab.{{ $k1 }}.name_kegiatan'
                                                type="text" class="form-control" placeholder="Nama Kegiatan">
                                        </td>
                                        <td><input wire:model='kegiatan_rab.{{ $k1 }}.total_kegiatan'
                                                type="text" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            {{-- <button wire:click='tambahRincian({{ $k1 }})'
                                                class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i></button> --}}
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    {{-- @foreach ($item['rincian'] as $k2 => $child)
                                        <tr wire:key='rincian-{{ $k1 }}-{{ $k2 }}'>
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
                                                    wire:click="hapusRincian({{ $k1 }},{{ $k2 }})"
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
                        <button wire:click='store' type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div wire:ignore.self class="modal fade" id="submit_modal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold" id="confirmSubmitModalLabel">Konfirmasi Simpan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fw-bold fs-5">Yakin akan simpan data RAB?</p>
                    <p class="text-muted">Periksa kembali dengan teliti, karena setelah disimpan data hanya bisa diubah
                        pada masa koreksi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" wire:click="saveRab" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('close-modal', function() {
                $("#create_modal").modal('hide');
            })
        });
    </script>
@endpush
