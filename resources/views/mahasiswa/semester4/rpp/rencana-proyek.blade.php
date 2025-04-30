@extends('layouts.dashboardmahasiswa-template')

@section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills nav-fill" id="tabs">
                <li class="nav-item"><a class="nav-link active" id="step1-tab" data-toggle="pill" href="#step1">1
                        Deskripsi Proyek</a></li>
                <li class="nav-item"><a class="nav-link" id="step2-tab" data-toggle="pill" href="#step2">2 Ruang Lingkup
                        & Rancangan Sistem</a></li>
                <li class="nav-item"><a class="nav-link" id="step3-tab" data-toggle="pill" href="#step3">3 Tahapan &
                        Kebutuhan</a></li>
                <li class="nav-item"><a class="nav-link" id="step4-tab" data-toggle="pill" href="#step4">4 Tantangan &
                        Estimasi</a></li>
                <li class="nav-item"><a class="nav-link" id="step5-tab" data-toggle="pill" href="#step5">5 Biaya &
                        Tim</a></li>
                <li class="nav-item"><a class="nav-link" id="step6-tab" data-toggle="pill" href="#step6">6 Mata Kuliah &
                        Evaluasi</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                {{-- Step 1 --}}
                <div class="tab-pane fade show active" id="step1">
                    <h5 class="mb-3 text-center">Form Deskripsi Proyek PBL Mahasiswa</h5>
                    <form>
                        {{-- Isi form --}}
                        <div class="form-group">
                            <label>Nomor ID Proyek</label>
                            <input type="text" class="form-control" value="3A_1" readonly>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <div class="w-50 me-3">
                                <label>Judul Proyek PBL</label>
                                <input type="text" class="form-control" placeholder="Masukan Judul Proyek PBL">
                            </div>
                            <div class="w-50">
                                <label>Pengusul Proyek</label>
                                <input type="text" class="form-control" placeholder="Masukan Pengusul Proyek">
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <div class="w-50 me-3">
                                <div class="form-group"><label>Manajer Proyek</label><input type="text" class="form-control"
                                    placeholder="Masukan Nama Manajer Proyek"></div>
                            </div>
                            <div class="w-50">
                                <div class="form-group"><label>Luaran</label><input type="text" class="form-control"
                                    placeholder="Masukan Luaran Proyek PBL"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <div class="w-50 me-3">
                                <div class="form-group"><label>Sponsor</label><input type="text" class="form-control"
                                    placeholder="Masukan Sponsor dari Proyek PBL"></div>
                            </div>
                            <div class="w-50">
                                <div class="form-group"><label>Biaya</label><input type="text" class="form-control"
                                    placeholder="Masukan Biaya Proyek PBL"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <div class="w-50 me-3">
                                <div class="form-group"><label>Klien/Pelanggan</label><input type="text" class="form-control"
                                    placeholder="Masukan Klien dari Proyek PBL"></div>
                            </div>
                            <div class="w-50">
                                <div class="form-group"><label>Waktu</label><input type="text" class="form-control"
                                    placeholder="Masukan Waktu Pelaksanaan Proyek PBL"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary me-2">Simpan</button>
                            <button type="button" class="btn btn-next btn-secondary"
                                data-next="#step2">Selanjutnya</button>
                        </div>
                    </form>
                </div>

                {{-- Step 2 --}}
                <div class="tab-pane fade" id="step2">
                    <h5 class="mb-3 text-center">Ruang Lingkup dan Rancangan Sistem</h5>
                    <form>
                        {{-- Isi form --}}
                        <div class="form-group">
                            <label>1. Ruang Lingkup</label>
                            <textarea name="ruang_lingkup" id="ruang_lingkup" class="form-control" rows="10"
                                placeholder="Jelaskan secara detail mengenai Ruang Lingkup Proyek PBL"></textarea>
                        </div>
                        <div class="form-group">
                            <label>2. Rancangan Sistem</label>
                            <textarea name="rancangan_sistem" id="rancangan_sistem" class="form-control" rows="10"
                                placeholder="Jelaskan secara detail mengenai Rancangan Sistem Proyek PBL"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-prev btn-outline-secondary"
                                    data-prev="#step1">Sebelumnya</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary me-2">Simpan</button>
                                <button type="button" class="btn btn-next btn-secondary"
                                    data-next="#step3">Selanjutnya</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Step 3 --}}
                <div class="tab-pane fade" id="step3">
                    <h5 class="mb-3 text-center">Tahapan Pelaksanaan & Kebutuhan Peralatan</h5>
                    <form>
                        {{-- Tahapan --}}
                        <label>3. Tahapan Pelaksanaan Proyek</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-tahapan">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Minggu Ke-</th>
                                        <th>Tahapan</th>
                                        <th>Person in Charge</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td class="text-wrap">Mengidentifikasi fitur tambahan yang akan dikembangkan
                                            dalam waktu pelaksanaan proyek</td>
                                        <td>[perwakilan tim]</td>
                                        <td>Keterangan</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- Kebutuhan Peralatan --}}
                        <label>4. Kebutuhan Peralatan</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-kebutuhan-peralatan">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Fase/Proses</th>
                                        <th>Peralatan/Perangkat (Software/Hardware)</th>
                                        <th>Bahan/Komponen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td class="text-wrap">Fase 1</td>
                                        <td>Komputer/Laptop</td>
                                        <td>Bahan 1</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <button type="button" class="btn btn-prev btn-outline-secondary"
                                    data-prev="#step1">Sebelumnya</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary me-2">Simpan</button>
                                <button type="button" class="btn btn-next btn-secondary"
                                    data-next="#step3">Selanjutnya</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Step 4 --}}
                <div class="tab-pane fade" id="step4">
                    <h5 class="mb-3 text-center">Tantangan & Estimasi Waktu</h5>
                    <form>
                        {{-- Tantangan --}}
                        <label>5. Tantangan dan Isu</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-tantangan">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Proses/Fase/Peralatan/Bahan</th>
                                        <th>Tantangan/Isu</th>
                                        <th>Level Risiko*</th>
                                        <th>Rencana Tindakan</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td class="text-wrap">Fase 1</td>
                                        <td>Tantangan 1</td>
                                        <td>M</td>
                                        <td>Rencana 1</td>
                                        <td>Catatan</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Keterangan footer -->
                            <div class="mt-2 text-muted" style="font-size: 14px;">
                                <strong>Keterangan:</strong> H: <span class="text-danger">High</span>; M: <span
                                    class="text-warning">Medium</span>; L: <span class="text-success">Low</span>
                            </div>
                        </div>
                        {{-- Estimasi Waktu --}}
                        <label>6. Estimasi Waktu</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-estimasi">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Fase/Proses</th>
                                        <th>Uraian Pekerjaan</th>
                                        <th>Estimasi Waktu</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td class="text-wrap">Fase 1</td>
                                        <td>Pekerjaan 1</td>
                                        <td>2 Minggu</td>
                                        <td>Catatan</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <button type="button" class="btn btn-prev btn-outline-secondary"
                                    data-prev="#step1">Sebelumnya</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary me-2">Simpan</button>
                                <button type="button" class="btn btn-next btn-secondary"
                                    data-next="#step3">Selanjutnya</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Step 5 --}}
                <div class="tab-pane fade" id="step5">
                    <h5 class="mb-3 text-center">Biaya & Tim Proyek</h5>
                    <form>
                        {{-- Biaya --}}
                        <label>7. Biaya Proyek (Biaya Bahan dan Peralatan)</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-biaya">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Fase/Proses</th>
                                        <th>Uraian Pekerjaan</th>
                                        <th>Perkiraan Biaya</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td class="text-wrap">Fase 1</td>
                                        <td>Pekerjaan 1</td>
                                        <td>Rp. 500.000</td>
                                        <td>Catatan</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- Tim --}}
                        <label>8. Tim proyek (Dosen, Laboran dan/atau Mahasiswa)</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-tim">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>NIK/NIM</th>
                                        <th>Program Studi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td>Achmad Nico W</td>
                                        <td>362355401017</td>
                                        <td>TRPL</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <button type="button" class="btn btn-prev btn-outline-secondary"
                                    data-prev="#step1">Sebelumnya</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary me-2">Simpan</button>
                                <button type="button" class="btn btn-next btn-secondary"
                                    data-next="#step3">Selanjutnya</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Step 6 --}}
                <div class="tab-pane fade" id="step6">
                    <h5 class="mb-3 text-center">Mata Kuliah & Evaluasi</h5>
                    <form>
                        {{-- Mata Kuliah --}}
                        <label>9. Mata Kuliah, Capaian Pembelajaran dan Tujuan Pembelajaran yang terlibat</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover" id="datatable-matkul">
                                <thead class="table-light font-weight-bold">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>Capaian Pembelajaran</th>
                                        <th>Tujuan Pembelajaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm font-weight-normal">
                                    <tr>
                                        <td>1</td>
                                        <td>Proyek Aplikasi Dasar</td>
                                        <td class="text-wrap">Capaian Pembelajaran</td>
                                        <td class="text-wrap">Tujuan Pembelajaran</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-secondary"><i
                                                        class="bi bi-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- Evaluasi --}}
                        <div class="form-group">
                            <label>10. Pemantauan dan Evaluasi</label>
                            <textarea name="evaluasi" id="evaluasi" class="form-control" rows="10"
                                placeholder="Jelaskan secara detail mengenai Evaluasi dari Proyek PBL yang dikerjakan"></textarea>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <button type="button" class="btn btn-prev btn-outline-secondary"
                                    data-prev="#step1">Sebelumnya</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary me-2">Simpan</button>
                                <button type="button" class="btn btn-next btn-secondary"
                                    data-next="#step3">Selanjutnya</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-link');

        // Fungsi untuk ganti tab
        function activateTab(targetId) {
            // Hapus class aktif dari semua tab
            document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

            // Aktifkan tab tujuan
            const targetPane = document.querySelector(targetId);
            const targetNav = document.querySelector(`[href="${targetId}"]`);

            if (targetPane && targetNav) {
                targetPane.classList.add('show', 'active');
                targetNav.classList.add('active');
            }
        }

        // Navigasi manual klik tab
        navLinks.forEach(tab => {
            tab.addEventListener('click', function () {
                activateTab(this.getAttribute('href'));
            });
        });

        // Tombol "Selanjutnya"
        document.querySelectorAll('.btn-next').forEach(button => {
            button.addEventListener('click', function () {
                const next = this.getAttribute('data-next');
                if (next) activateTab(next);
            });
        });

        // Tombol "Sebelumnya"
        document.querySelectorAll('.btn-prev').forEach(button => {
            button.addEventListener('click', function () {
                const prev = this.getAttribute('data-prev');
                if (prev) activateTab(prev);
            });
        });
    });
</script>
@endpush
