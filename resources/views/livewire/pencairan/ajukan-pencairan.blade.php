<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pencairan Dana Hibah</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan') }}">Permohonan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan.show', $permohonan->id) }}">Detail</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajukan Pencairan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pengajuan Pencairan Dana Hibah</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <!-- Informasi Permohonan -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Informasi Permohonan</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Lembaga:</small>
                                    <p class="mb-1">{{ $permohonan->lembaga->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Perihal:</small>
                                    <p class="mb-1">{{ $permohonan->perihal_mohon }}</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted">Total Anggaran:</small>
                                    <p class="mb-0"><strong>Rp
                                            {{ number_format($permohonan->jumlah_mohon, 0, ',', '.') }}</strong></p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted">Sudah Dicairkan:</small>
                                    <p class="mb-0"><strong>Rp
                                            {{ number_format($totalDicairkan, 0, ',', '.') }}</strong></p>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <small class="text-muted">Sisa Dana:</small>
                                    <p class="mb-0 text-success"><strong>Rp
                                            {{ number_format($sisaDana, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- Tahap Pencairan -->
                        <div class="mb-3">
                            <label class="form-label">Tahap Pencairan <span class="text-danger">*</span></label>
                            <select wire:model="tahap_pencairan"
                                class="form-select @error('tahap_pencairan') is-invalid @enderror">
                                <option value="">-- Pilih Tahap --</option>
                                <option value="1">Tahap 1 (Down Payment)</option>
                                <option value="2">Tahap 2 (Progress Payment)</option>
                                <option value="3">Tahap 3 (Final Payment)</option>
                            </select>
                            @error('tahap_pencairan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih tahap pencairan sesuai dengan progress kegiatan</small>
                        </div>

                        <!-- Tanggal Pencairan -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pencairan <span class="text-danger">*</span></label>
                            <input type="date" wire:model="tanggal_pencairan"
                                class="form-control @error('tanggal_pencairan') is-invalid @enderror">
                            @error('tanggal_pencairan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Pencairan -->
                        <div class="mb-3">
                            <label class="form-label">Jumlah Pencairan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" wire:model="jumlah_pencairan"
                                    class="form-control @error('jumlah_pencairan') is-invalid @enderror"
                                    placeholder="Masukkan jumlah pencairan" x-data
                                    x-on:input="$el.value = $el.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                                @error('jumlah_pencairan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Maksimal: Rp {{ number_format($sisaDana, 0, ',', '.') }}</small>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea wire:model="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Keterangan tambahan (opsional)"></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dokumen Pendukung -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Dokumen Pendukung <span class="text-danger">*</span></h6>
                            </div>
                            <div class="card-body">
                                <!-- File LPJ -->
                                <div class="mb-3">
                                    <label class="form-label">Laporan Pertanggungjawaban (LPJ) <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_lpj"
                                        class="form-control @error('file_lpj') is-invalid @enderror" accept=".pdf">
                                    @error('file_lpj')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PDF, Max: 2MB</small>
                                    <div wire:loading wire:target="file_lpj" class="text-primary mt-1">
                                        <i class="bi bi-arrow-repeat spinner-border spinner-border-sm"></i> Uploading...
                                    </div>
                                </div>

                                <!-- File Realisasi -->
                                <div class="mb-3">
                                    <label class="form-label">Laporan Realisasi Kegiatan <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_realisasi"
                                        class="form-control @error('file_realisasi') is-invalid @enderror"
                                        accept=".pdf">
                                    @error('file_realisasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PDF, Max: 2MB</small>
                                    <div wire:loading wire:target="file_realisasi" class="text-primary mt-1">
                                        <i class="bi bi-arrow-repeat spinner-border spinner-border-sm"></i>
                                        Uploading...
                                    </div>
                                </div>

                                <!-- File Dokumentasi -->
                                <div class="mb-3">
                                    <label class="form-label">Dokumentasi Kegiatan <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_dokumentasi"
                                        class="form-control @error('file_dokumentasi') is-invalid @enderror"
                                        accept=".pdf,.zip,.rar">
                                    @error('file_dokumentasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PDF/ZIP/RAR, Max: 5MB</small>
                                    <div wire:loading wire:target="file_dokumentasi" class="text-primary mt-1">
                                        <i class="bi bi-arrow-repeat spinner-border spinner-border-sm"></i>
                                        Uploading...
                                    </div>
                                </div>

                                <!-- File Kwitansi -->
                                <div class="mb-3">
                                    <label class="form-label">Kwitansi/Bukti Pengeluaran <span
                                            class="text-danger">*</span></label>
                                    <input type="file" wire:model="file_kwitansi"
                                        class="form-control @error('file_kwitansi') is-invalid @enderror"
                                        accept=".pdf">
                                    @error('file_kwitansi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PDF, Max: 2MB</small>
                                    <div wire:loading wire:target="file_kwitansi" class="text-primary mt-1">
                                        <i class="bi bi-arrow-repeat spinner-border spinner-border-sm"></i>
                                        Uploading...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('permohonan.show', $permohonan->id) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                wire:target="submit">
                                <span wire:loading.remove wire:target="submit">
                                    <i class="bi bi-send"></i> Ajukan Pencairan
                                </span>
                                <span wire:loading wire:target="submit">
                                    <i class="bi bi-arrow-repeat spinner-border spinner-border-sm"></i> Processing...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Riwayat Pencairan -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Riwayat Pencairan</h6>
                </div>
                <div class="card-body">
                    @forelse($permohonan->pencairans()->orderBy('tahap_pencairan')->get() as $p)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Tahap {{ $p->tahap_pencairan }}</h6>
                                <small class="text-muted">{{ $p->tanggal_pencairan->format('d M Y') }}</small>
                                <p class="mb-0 mt-1">
                                    <strong>Rp {{ number_format($p->jumlah_pencairan, 0, ',', '.') }}</strong>
                                </p>
                            </div>
                            <div>
                                @php
                                    $badgeClass = match ($p->status) {
                                        'diajukan' => 'bg-warning',
                                        'diverifikasi' => 'bg-info',
                                        'disetujui' => 'bg-primary',
                                        'ditolak' => 'bg-danger',
                                        'dicairkan' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($p->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada riwayat pencairan</p>
                    @endforelse
                </div>
            </div>

            <!-- Panduan -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Panduan Pengajuan</h6>
                </div>
                <div class="card-body">
                    <ol class="mb-0" style="font-size: 0.9rem;">
                        <li>Pastikan semua dokumen sudah disiapkan</li>
                        <li>Pilih tahap pencairan sesuai progress</li>
                        <li>Isi jumlah pencairan tidak melebihi sisa dana</li>
                        <li>Upload dokumen dalam format yang benar</li>
                        <li>Tunggu proses verifikasi dan approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</div>
