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
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav mt-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
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
            <!-- Master Data -->
            <li class="nav-item mt-2">
                <a class="nav-link {{ request()->routeIs('admin.periodepbl*') || request()->routeIs('admin.matkul*') || request()->routeIs('admin.kelas*') || request()->routeIs('admin.dosen*') || request()->routeIs('admin.mahasiswa*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#masterData" role="button"
                    aria-expanded="{{ request()->routeIs('admin.periodepbl*') || request()->routeIs('admin.matkul*') || request()->routeIs('admin.kelas*') || request()->routeIs('admin.dosen*') || request()->routeIs('admin.mahasiswa*') ? 'true' : 'false' }}"
                    aria-controls="masterData">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-briefcase-24 text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Data</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.periodepbl*') || request()->routeIs('admin.matkul*') || request()->routeIs('admin.kelas*') || request()->routeIs('admin.dosen*') || request()->routeIs('admin.mahasiswa*') ? 'show' : '' }}"
                    id="masterData">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('admin.periodepbl*') ? 'active' : '' }}"
                                href="{{ route('admin.periodepbl') }}">
                                Periode PBL
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('admin.matkul*') ? 'active' : '' }}"
                                href="{{ route('admin.matkul') }}">
                                Mata Kuliah
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('admin.kelas*') ? 'active' : '' }}"
                                href="{{ route('admin.kelas') }}">
                                Kelas
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('admin.dosen*') ? 'active' : '' }}"
                                href="{{ route('admin.dosen') }}">
                                Data Dosen
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link {{ request()->routeIs('admin.mahasiswa*') ? 'active' : '' }}"
                                href="{{ route('admin.mahasiswa') }}">
                                Data Mahasiswa
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Dosen Pengampu --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pengampu*') ? 'active' : '' }}"
                    href="{{ route('admin.pengampu') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-hat-3 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kelola Dosen Pengampu</span>
                </a>
            </li>
            {{-- Tahapan Pelaksanaan Proyek --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tpp*') ? 'active' : '' }}"
                    href="{{ route('admin.tpp') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text-fill text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tahapan Pelaksanaan Proyek</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
