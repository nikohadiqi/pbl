<!-- resources/views/mahasiswa/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
</head>

<body>
    <h1>Welcome, {{ Auth::user()-> name }}</h1>
    <p>Ini adalah halaman dashboard khusus untuk Mahasiswa.</p>
    <button id="logout-btn" class="btn btn-danger">Logout</button>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

</body>

</html>