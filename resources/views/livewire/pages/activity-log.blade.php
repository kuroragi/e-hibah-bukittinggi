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
            <div wire:poll.10m class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Event</th>
                            <th>Context</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="{{ $log->timestamp }}">
                                <td>{{ $log->event }}</td>
                                <td>
                                    <pre>
                                        {{ json_encode($Log['context'], JSON_PRETTY_PRINT) }}
                                    </pre>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-2">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
