<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header d-md-flex align-items-center px-2 mt-3">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-3 top-3 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <img src="../assets/img/logo-poliwangi.png" width="30" height="30" class="navbar-brand-img h-100 me-2" alt="Logo">
        <div style="line-height: 1;">
            <span class="font-weight-bolder d-block" style="font-size: 12px; width: 280px">Sistem Informasi dan Monitoring</span>
            <span class="font-weight-bolder" style="font-size: 12px;">Project Based Learning</span>
        </div>
    </div>
    <hr class="horizontal dark mt-3">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav mt-1">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-cast text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">MENU</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-people-fill text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tim PBL</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link " href="#">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-fill text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Periode PBL</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link " href="#">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tahapan Pelaksanaan Proyek</span>
                </a>
            </li>
            <!-- Master Data -->
            <li class="nav-item mt-2">
                <a class="nav-link" data-bs-toggle="collapse" href="#masterData" role="button" aria-expanded="false" aria-controls="masterData">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-copy-04 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Data</span>
                </a>
                <div class="collapse" id="masterData">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item mt-2"><a class="nav-link" href="#">Mata Kuliah</a></li>
                        <li class="nav-item mt-2"><a class="nav-link" href="#">Akun Mahasiswa</a></li>
                        <li class="nav-item mt-2"><a class="nav-link" href="#">Akun Dosen</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
