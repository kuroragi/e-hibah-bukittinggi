<div>

    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                <h3 class="font-semibold mt-6 mb-2">RAB</h3>
                <div class="row mb-4">

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="totalPengajuan" class="form-label">Total Pengajuan <span
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
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                <h3 class="font-semibold mt-6 mb-2">RAB</h3>
                <div class="mb-3">
                    <button wire:click='generate_pdf' class="btn btn-sm btn-success">Download Surat</button>
                </div>
                <div class="mb-3">
                    <lable class="form-label">Surat permohonan penandatanganan NPHD Hibah Berupa uang</lable>
                    <input type="file" wire:model='file_permintaan_nphd' class="form-control">
                </div>
                <div class="modal-footer">
                    <button wire:click.prevent='store' type="button" class="btn btn-primary">Simpan Permintaan</button>
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
