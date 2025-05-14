@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Rubrik Penilaian')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="align-items-center card-header">
            <h4 class="fw-bold">Rubrik Nilai</h4>
            <p class="text-sm">{ Nama Mahasiswa }</p>
        </div>
        <div class="card-body">
            <button class="btn btn-primary text-white fw-bold">Simpan Nilai</button>
            <form id="rubrikForm">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-info">
                        <tr>
                            <th>Metode Asesmen</th>
                            <th>Aspek Penilaian</th>
                            <th>Bobot</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody id="rubrikTable">
                        @for($i = 0; $i < 5; $i++) <tr>
                            <td>Item</td>
                            <td>Item</td>
                            <td><input type="number" name="bobot[]" class="form-control bobot" min="0.01" max="1"
                                    step="0.01" value="0.2" onchange="hitungTotal()"></td>
                            <td>
                                @for($n = 1; $n <= 4; $n++) <label class="me-2">
                                    <input type="radio" name="nilai{{$i}}" value="{{$n}}" onclick="hitungTotal()">
                                    {{$n}}
                                    </label>
                                    @endfor
                            </td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
                <div class="mt-2 bg-info text-white p-3">
                    <p><strong>Total Nilai (0-4):</strong> <span id="totalNilai">0</span></p>
                    <p><strong>Angka Nilai:</strong> <span id="angkaNilai">0</span></p>
                    <p><strong>Huruf Nilai:</strong> <span id="hurufNilai">-</span></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function hitungTotal() {
      let totalNilai = 0;
      let totalBobot = 0;

      document.querySelectorAll("#rubrikTable tr").forEach((row, index) => {
        const bobot = parseFloat(row.querySelector(".bobot").value) || 0;
        const nilaiChecked = row.querySelector('input[name="nilai' + index + '"]:checked');
        const nilai = nilaiChecked ? parseInt(nilaiChecked.value) : 0;
        totalNilai += (nilai * bobot);
      });

      const angkaNilai = (totalNilai * 25).toFixed(2);
      const huruf = konversiHuruf(angkaNilai);

      document.getElementById("totalNilai").textContent = totalNilai.toFixed(2);
      document.getElementById("angkaNilai").textContent = angkaNilai;
      document.getElementById("hurufNilai").textContent = huruf;
    }

    function konversiHuruf(nilai) {
      nilai = parseFloat(nilai);
      if (nilai >= 85) return "A";
      if (nilai >= 80) return "A-";
      if (nilai >= 75) return "B+";
      if (nilai >= 70) return "B";
      if (nilai >= 65) return "B-";
      if (nilai >= 60) return "C+";
      if (nilai >= 55) return "C";
      if (nilai >= 50) return "C-";
      if (nilai >= 40) return "D";
      return "E";
    }
</script>
@endpush
