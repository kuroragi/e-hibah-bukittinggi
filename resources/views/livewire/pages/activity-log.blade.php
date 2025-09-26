<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Log Aktivitas</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Log Aktivitas</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="date" wire:model.live="dateFilter" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari log...">
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Waktu</th>
                        <th>Event</th>
                        <th>User</th>
                        <th>Deskripsi</th>
                        <th>Level</th>
                        <th>meta</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log['timestamp'] ?? '' }}</td>
                            <td>{{ $log['event'] ?? '' }}</td>
                            <td>{ user_id: '{{ $log['user']['id'] ?? 'unknown' }}', user_name:
                                '{{ $log['user']['name'] ?? 'unknown' }}', role:
                                '{{ $log['user']['role'] ?? 'unknown' }}' }
                            </td>
                            <td>{ description: '{{ $log['context']['description'] ?? '-' }}', data:
                                {{ $log['context']['data'] ?? '{}' }} }</td>
                            <td>
                                <span class="badge bg-{{ $log['level'] ?? 'light' }}">
                                    {{ $log['level'] ?? '' }}
                                </span>
                            </td>
                            <td>
                                { ip_address: '{{ $log['meta']['ip_address'] ?? '0.0.0.0' }}', user_agent:
                                '{{ $log['meta']['user_agent'] ?? 'unknown' }}' }
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada log aktivitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
