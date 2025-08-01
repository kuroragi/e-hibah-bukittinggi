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
                    @can('viewAny', Auth::user())
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
                    @endcan

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
                    @if (Auth::user()->hasRole('Admin Lembaga') && Auth::user()->id_lembaga == null)
                        <a href="{{ route('lembaga.uncreate') }}" class="list-group-item"><i class="bi bi-building"></i>
                            Lembaga</a>
                    @elseif (Auth::user()->hasRole('Super Admin'))
                        <a href="{{ route('lembaga') }}" class="list-group-item"><i class="bi bi-building"></i>
                            Lembaga</a>
                    @else
                        <a href="{{ route('lembaga.show') }}" class="list-group-item"><i class="bi bi-building"></i>
                            Lembaga</a>
                    @endif
                    <a href="{{ route('permohonan') }}" class="list-group-item"><i
                            class="bi bi-chat-left-text"></i>Permohonan</a>
                    <a href="javascript::" class="list-group-item"><i class="bi bi-file-earmark-post"></i>NPHD
                        Manager</a>
                    <a href="javascript::" class="list-group-item"><i class="bi bi-file-earmark-ruled"></i>Laporan</a>
                </div>
            </div>
        </div>
    </div>
</aside>
<!--start sidebar -->
