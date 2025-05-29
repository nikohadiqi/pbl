<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header d-md-flex align-items-center px-2">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-3 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <img src="{{ url('assets/img/logo-poliwangi.png') }}" width="30" height="30"
            class="navbar-brand-img h-100 me-2" alt="Logo">
        <div style="line-height: 1;">
            <span class="font-weight-bolder d-block" style="font-size: 12px; width: 280px">Sistem Informasi dan
                Monitoring</span>
            <span class="font-weight-bolder" style="font-size: 12px;">Project Based Learning</span>
        </div>
    </div>
    <hr class="horizontal dark mt-3">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav mt-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
                    href="{{ route('mahasiswa.dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-cast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dasbor</span>
                </a>
            </li>

            {{-- Menu --}}
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">MENU</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.rpp.rencana-proyek.create') ? 'active' : '' }}"
                    href="{{ route('mahasiswa.rpp.rencana-proyek.create') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Rencana Pelaksanaan Proyek</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.logbook*') ? 'active' : '' }}"
                    href="{{ route('mahasiswa.logbook') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-journal-check text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logbook Mingguan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.pelaporan-pbl*') ? 'active' : '' }}"
                    href="{{ route('mahasiswa.pelaporan-pbl') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-arrow-up text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pelaporan PBL</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
