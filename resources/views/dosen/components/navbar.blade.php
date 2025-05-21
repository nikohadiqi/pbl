<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                        href="{{ route('admin.dashboard') }}">Dasbor</a></li>
                @hasSection('page-title-1')
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" href="@yield('page-title-1-url')">@yield('page-title-1')</a>
                </li>
                @endif
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('page-title')</li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">@yield('page-title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-auto justify-content-end">
                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/img/logo-poliwangi.png') }}" alt="User Avatar"
                            class="rounded-circle me-2 border border-2 border-light p-1" width="40" height="40">
                        <span class="d-flex flex-column text-white">
                            <span class="fw-bold">
                                {{ Auth::guard('dosen')->user()->dosen->nama ?? '-' }}
                            </span>
                            <span class="fw-bold">
                                {{ Auth::guard('dosen')->user()->dosen->nip ?? '-' }}
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('dosen.profil') }}"><i class="fas fa-user me-2"></i>
                                Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a id="logout-btn" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
