<!--start sidebar -->
<aside class="sidebar-wrapper">
    <div class="iconmenu">
        <div class="nav-toggle-box">
            <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
        </div>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboards">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-dashboards" type="button"><i
                        class="bi bi-house-door-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Menu">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-menu" type="button"><i
                        class="bi bi-grid-fill"></i></button>
            </li>
        </ul>
    </div>
    <div class="textmenu">
        <div class="brand-logo">
            <img src="/assets/images/logo/bkt.png" height="45px" alt="" />
            <h4>E-Hibah</h4>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="pills-dashboards">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Dashboards</h5>
                        </div>
                        <small class="mb-0">Halaman Utama</small>
                    </div>
                    <a href="{{ route('dashboard') }}" class="list-group-item"><i class="bi bi-house"></i>
                        Dashboard</a>
                    <a href="{{ route('user.change_password') }}" class="list-group-item"><i class="bi bi-key"></i>
                        Ubah Sandi</a>
                    @can('viewAny', App\Models\Permission::class)
                    <a href="{{ route('permission') }}" class="list-group-item"><i class="bi bi-person-lock"></i>
                        Permission</a>
                    @endcan
                    @can('viewAny', App\Models\Role::class)
                    <a href="{{ route('role') }}" class="list-group-item"><i class="bi bi-person-badge"></i>
                        Role</a>
                    @endcan
                    @can('viewAny', App\Models\Skpd::class)
                    <a href="{{ route('skpd') }}" class="list-group-item"><i class="bi bi-building"></i>SKPD</a>
                    @endcan
                    @can('viewAny', App\Models\User::class)
                    <a href="{{ route('user.index') }}" class="list-group-item"><i class="bi bi-people"></i>
                        Pengguna</a>
                    <a href="{{ route('user.log') }}" class="list-group-item"><i
                            class="bi bi-file-earmark-person"></i>Log
                        Pengguna</a>
                    @endcan
                    @can('View Any Pertanyaan', App\Models\PertanyaanKelengkapan::class)
                    <a href="{{ route('pertanyaan') }}" class="list-group-item"><i class="bi bi-question-square"></i>
                        Pertanyaan</a>
                    @endcan
                    <a href="{{ route('user_guide') }}" class="list-group-item"><i
                            class="bi bi-question text-success"></i>
                        Panduan Penggunaan</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-menu">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Lembaga</h5>
                        </div>
                        <small class="mb-0">Menu Untuk Lembaga</small>
                    </div>
                    @can('viewAny', App\Models\Lembaga::class)
                    <a href="{{ route('lembaga') }}" class="list-group-item"><i class="bi bi-building"></i>
                        Lembaga</a>
                    @endcan
                    @can('viewLembaga', App\Models\Lembaga::class)
                    <a href="{{ route('lembaga.admin', ['id_lembaga' => Auth::user()->id_lembaga ?? 0]) }}"
                        class="list-group-item"><i class="bi bi-building"></i>
                        Lembaga</a>
                    @endcan
                    @can('viewAny', App\Models\Permohonan::class)
                    @if (!auth()->user()->hasRole('Admin Lembaga') || auth()->user()->id_lembaga != null)
                    @php
                    if (
                    auth()
                    ->user()
                    ->hasAnyRole(['Super Admin', 'Admin Skpd'])
                    ) {
                    $badgeCount =
                    $permohonanCounts['review_permohonan'] +
                    $permohonanCounts['confirm_permohonan'];
                    } elseif (auth()->user()->hasRole('Verifikator')) {
                    $badgeCount = $permohonanCounts['confirm_permohonan'];
                    } elseif (auth()->user()->hasRole('Reviewer')) {
                    $badgeCount = $permohonanCounts['review_permohonan'];
                    } else {
                    $badgeCount = 0;
                    }
                    @endphp
                    <a href="{{ route('permohonan') }}" class="list-group-item"><i
                            class="bi bi-chat-left-text"></i>Permohonan Hibah
                        @if ($badgeCount > 0)
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">+{{
                            $badgeCount }}
                            <span class="visually-hidden">unread messages</span></span>
                        @endif
                    </a>
                    @endif
                    @endcan
                    @if (!auth()->user()->hasRole('Admin Lembaga') || auth()->user()->id_lembaga != null)
                    @can('viewAnyNphd', App\Models\Permohonan::class)
                    <a href="{{ route('nphd') }}" class="list-group-item"><i
                            class="bi bi-file-earmark-post"></i>Pengajuan NPHD</a>
                    @endcan
                    <a href="{{ route('pencairan') }}" class="list-group-item"><i class="bi bi-file"></i>Pencairan</a>
                    @endif

                    {{-- <a href="javascript::" class="list-group-item"><i
                            class="bi bi-file-earmark-ruled"></i>Laporan</a> --}}
                </div>
            </div>
        </div>
    </div>
</aside>
<!--start sidebar -->