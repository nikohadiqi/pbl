<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('assets/img/logo-poliwangi.png') }}">
    <link rel="icon" type="image/png" href="{{ url('assets/img/logo-poliwangi.png') }}">
    <title>
        @yield('title')
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{ url('assets/css/nucleo-icons.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/nucleo-svg.css') }}" rel="stylesheet">
    {{-- bootstrap icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    {{--
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.11.5/datatables.min.css" /> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ url('assets/css/argon-dashboard.css') }}" rel="stylesheet" />

    {{-- Nav Style --}}
    <style>
        .navbar .dropdown-toggle {
            color: white !important;
            background-color: transparent;
            border: none;
            padding: 0.5rem 0.1rem;
            border-radius: 0.75rem;
            transition: background-color 0.3s ease;
        }

        /* Hover effect opsional */
        .navbar .dropdown-toggle:hover,
        .navbar .dropdown-toggle:focus {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .dropdown-menu .dropdown-item.text-danger:hover {
            background-color: #ffcccc;
            color: #a00;
        }
    </style>

    @stack('css')
</head>

<body class="g-sidenav-show bg-body-custom">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <div class="container-fluid d-flex"></div>
    <!-- sidebar menu -->
    @include('admin.components.sidebar')
    <!-- end of sidebar menu -->
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('admin.components.navbar')
        <!-- Main Content -->
        @yield('content')
        <!-- Footer -->
        @include('admin.components.footer')
    </main>
    <!-- Konfigurasi Style -->
    @include('admin.components.configuration-style')
    <!-- End of Konfigurasi Style -->

    {{-- Sweetalert --}}
    @include('sweetalert::alert')
    <script src="{{ url('assets/js/plugins/sweetalert.min.js') }}"></script>

    {{-- Logout --}}
    <script>
        document.getElementById('logout-btn').addEventListener('click', function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin ingin logout?',
            text: "Anda harus login kembali setelah keluar!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
    </script>

    <!--   Core JS Files   -->
    @stack('script')

    <script src="{{ url('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ url('assets/js/core/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ url('') }}/assets/js/core/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ url('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    {{-- Datatables --}}
    <script src="{{ url('assets/js/plugins/datatables.js') }}"></script>
    <script>
        const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
            searchable: true,
            sortable: true,
            perPageSelect: [5, 10, 20, 50],
            fixedHeight: true,
            labels: {
                placeholder: "Cari...",
                perPage: "{select} data per halaman",
                noRows: "Tidak ada data",
                info: "Menampilkan {start} sampai {end} dari {rows} data"
            }
        });
    </script>
    <script>
        const dataTableBasic = new simpleDatatables.DataTable("#datatable-basic", {
        searchable: false,
            sortable: true,
            perPageSelect: [5, 10, 20, 50],
            fixedHeight: true,
            labels: {
                placeholder: "Cari...",
                perPage: "{select} data per halaman",
                noRows: "Tidak ada data",
                info: "Menampilkan {start} sampai {end} dari {rows} data"
        }
    });
    </script>
    <script>
        const dataTableNormal = new simpleDatatables.DataTable("#datatable-normal", {
        searchable: false,
            sortable: true,
            perPageSelect: [5, 10, 20, 50],
            fixedHeight: true,
            labels: {
                placeholder: "Cari...",
                perPage: "{select} data per halaman",
                noRows: "Tidak ada data",
                info: "Menampilkan {start} sampai {end} dari {rows} data"
        }
    });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ url('assets/js/argon-dashboard.js') }}"></script>
</body>

</html>
