<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pencairan Dana Hibah</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pencairan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h5 class="card-title mb-0">Daftar Pencairan Dana Hibah</h5>
                    <p class="text-muted">Kelola pencairan dana hibah untuk lembaga</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari lembaga atau perihal...">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="diajukan">Diajukan</option>
                        <option value="diverifikasi">Diverifikasi</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="dicairkan">Dicairkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="tahapFilter" class="form-select">
                        <option value="">Semua Tahap</option>
                        <option value="1">Tahap 1</option>
                        <option value="2">Tahap 2</option>
                        <option value="3">Tahap 3</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="tahunFilter" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    @if(auth()->user()->hasRole('Admin Lembaga'))
                        <a href="{{ route('permohonan') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Ajukan Pencairan
                        </a>
                    @endif
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            @if(!auth()->user()->hasRole('Admin Lembaga'))
                                <th>Lembaga</th>
                            @endif
                            <th>Perihal Permohonan</th>
                            <th>Tahap</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Jumlah Pencairan</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pencairans as $key => $pencairan)
                            <tr>
                                <td>{{ $pencairans->firstItem() + $key }}</td>
                                @if(!auth()->user()->hasRole('Admin Lembaga'))
                                    <td>{{ $pencairan->permohonan->lembaga->name ?? '-' }}</td>
                                @endif
                                <td>{{ $pencairan->permohonan->perihal_mohon ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-info">Tahap {{ $pencairan->tahap_pencairan }}</span>
                                </td>
                                <td>{{ $pencairan->tanggal_pencairan->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span>{{ number_format($pencairan->jumlah_pencairan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($pencairan->status) {
                                            'diajukan' => 'bg-warning',
                                            'diverifikasi' => 'bg-info',
                                            'disetujui' => 'bg-primary',
                                            'ditolak' => 'bg-danger',
                                            'dicairkan' => 'bg-success',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($pencairan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pencairan.show', $pencairan->id) }}" 
                                           class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if(auth()->user()->hasRole('Reviewer') || auth()->user()->hasRole('Admin SKPD'))
                                            @if($pencairan->status == 'diajukan')
                                                <a href="{{ route('pencairan.verifikasi.detail', $pencairan->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Verifikasi">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                            @endif
                                        @endif

                                        @if(auth()->user()->hasRole('Admin SKPD') || auth()->user()->hasRole('Super Admin'))
                                            @if($pencairan->status == 'diverifikasi')
                                                <a href="{{ route('pencairan.approval.detail', $pencairan->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Approval">
                                                    <i class="bi bi-check2-all"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Tidak ada data pencairan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $pencairans->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto refresh every 30 seconds
        setInterval(() => {
            @this.call('$refresh');
        }, 30000);
    </script>
    @endpush
</div>
