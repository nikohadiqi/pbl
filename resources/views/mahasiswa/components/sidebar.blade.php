<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header d-md-flex align-items-center px-2">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-3 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <img src="{{ asset('assets/img/logo-poliwangi.png') }}" width="30" height="30"
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
            {{-- Semester 4 --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.rpp.rencana-proyek.create') || request()->routeIs('mahasiswa.logbook*') || request()->routeIs('mahasiswa.pelaporan-pbl*')  ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#semester4" role="button"
                    aria-expanded="{{ request()->routeIs('mahasiswa.rpp.rencana-proyek.create') || request()->routeIs('mahasiswa.logbook*') || request()->routeIs('mahasiswa.pelaporan-pbl*')  ? 'true' : 'false' }}"
                    aria-controls="semester4">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-activity text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Semester 4</span>
                </a>
                <div class="collapse {{ request()->routeIs('mahasiswa.rpp.rencana-proyek.create') || request()->routeIs('mahasiswa.logbook*') || request()->routeIs('mahasiswa.pelaporan-pbl*')  ? 'show' : '' }}"
                    id="semester4">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.rpp.rencana-proyek.create') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.rpp.rencana-proyek.create') }}">
                                Rencana Pelaksanaan Proyek
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.logbook*') ? 'active' : '' }}" href="{{ route('mahasiswa.logbook') }}">
                                Logbook Mingguan
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.pelaporan-pbl*') ? 'active' : '' }}" href="{{ route('mahasiswa.pelaporan-pbl') }}">
                                Pelaporan PBL
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Semester 5 --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.rpp.sem5') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#semester5" role="button"
                    aria-expanded="{{ request()->routeIs('mahasiswa.rpp.sem5') ? 'true' : 'false' }}"
                    aria-controls="semester5">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-activity text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Semester 5</span>
                </a>
                <div class="collapse {{ request()->routeIs('mahasiswa.rpp.sem5') ? 'show' : '' }}"
                    id="semester5">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.rpp.sem5') ? 'active' : '' }}"
                                href="#">
                                Rencana Pelaksanaan Proyek
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.logbook.sem5') ? 'active' : '' }}" href="#">
                                Logbook Mingguan
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.pelaporan.sem5') ? 'active' : '' }}" href="#">
                                Pelaporan PBL
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
