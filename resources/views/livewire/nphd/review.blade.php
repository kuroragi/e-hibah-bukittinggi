<div>
    @if ($step == 1)
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="font-semibold mt-6 mb-2">Rab</h3>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="totalPengajuan" class="form-label">Nominal Anggarab <span
                                class="text-danger">*</span></label>
                        <input wire:model.change='nominal_anggaran' type="number" class="form-control"
                            id="totalPengajuan" placeholder="Masukkan total pengajuan" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nominalRAB" class="form-label">Nominal RAB <span
                                class="text-danger">*</span></label>
                        <input type="text" wire:model='total_kegiatan' class="form-control" id="nominalRAB"
                            placeholder="Masukkan nominal RAB" readonly>
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
                            @foreach ($kegiatans as $kegiatan)
                                <tr>
                                    <td lass="text-start">{{ $kegiatan->nama_kegiatan }}</td>
                                    <td class="d-flex justify-content-between"><span>Rp.</span>
                                        {{ number_format($kegiatan->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <button wire:click.prevent='nextStep' type="button" class="btn btn-primary">Selanjutnya</button>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 2)
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="font-semibold mt-6 mb-4">Permohonan NPHD</h3>
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <p class="text-wrap">Surat Permohonan Penandatanganan NPHD Hibah Berupa Uang</p><br>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#fileModal"
                            data-file-url="{{ Storage::url($permohonan->file_permintaan_nphd) }}">Lihat
                            Dokumen</button>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button wire:click.prevent='prevStep' type="button" class="btn btn-warning">Sebelumnya</button>
                    <button wire:click.prevent='nextStep' type="button" class="btn btn-primary">Selanjutnya</button>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 3)
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <div class="text-center mb-3">
                    <h3 class="font-semibold mt-6 mb-2">Apakah Surat Penandatangan Sudah tepat?</h3>
                    <button class="btn btn-sm btn-primary me-3">Ya</button>
                    <button class="btn btn-sm btn-danger">Tidak</button>
                </div>

                <div class="mb-4">
                    <p>Surat NPHD</p><br>
                    <button wire:click='generate_pdf' class="btn btn-sm btn-warning">Download Surat</button>
                </div>

                <div class="card-footer text-end">
                    <button wire:click.prevent='prevStep' type="button" class="btn btn-warning">Sebelumnya</button>
                    <button wire:click.prevent='saveNphd' type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    @endif

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

            Livewire.on('pdf-ready', function(data) {
                window.open(data[0].url, '_blank');
            });

            Livewire.on('close-modal', function() {
                $("#update_rab_modal").modal('hide');
            })
        });
    </script>
@endpush
