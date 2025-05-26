<div class="tab-pane fade {{ session('active_step') == 'step6' ? 'show active' : '' }}" id="step6" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.estimasi.store') }}">
        @csrf
        <h4 class="mb-4">Estimasi Waktu Pekerjaan</h4>

        <table class="table table-bordered" id="estimasi-table">
            <thead>
                <tr>
                    <th>Fase</th>
                    <th>Uraian Pekerjaan</th>
                    <th>Estimasi Waktu</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php $oldCount = count(old('fase', [])); @endphp
                @if($oldCount > 0)
                @for($i = 0; $i < $oldCount; $i++) <tr>
                    <td><input type="text" name="fase[]" class="form-control" value="{{ old('fase.' . $i) }}"></td>
                    <td><input type="text" name="uraian_pekerjaan[]" class="form-control"
                            value="{{ old('uraian_pekerjaan.' . $i) }}"></td>
                    <td><input type="text" name="estimasi_waktu[]" class="form-control"
                            value="{{ old('estimasi_waktu.' . $i) }}"></td>
                    <td><input type="text" name="catatan[]" class="form-control" value="{{ old('catatan.' . $i) }}">
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endfor
                    @elseif(isset($estimasi) && $estimasi->count())
                    @foreach($estimasi as $estimasi)
                    <tr>
                        <td><input type="text" name="fase[]" class="form-control" value="{{ $estimasi->fase }}"></td>
                        <td><input type="text" name="uraian_pekerjaan[]" class="form-control"
                                value="{{ $estimasi->uraian_pekerjaan }}"></td>
                        <td><input type="text" name="estimasi_waktu[]" class="form-control"
                                value="{{ $estimasi->estimasi_waktu }}"></td>
                        <td><input type="text" name="catatan[]" class="form-control" value="{{ $estimasi->catatan }}">
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td><input type="text" name="fase[]" class="form-control"></td>
                        <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
                        <td><input type="text" name="estimasi_waktu[]" class="form-control"></td>
                        <td><input type="text" name="catatan[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endif
            </tbody>
        </table>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addEstimasiRow()">+ Tambah Estimasi</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step5">Previous</button>
            <div>
                <button type="submit" class="btn btn-success me-3"><i class="bi bi-floppy me-1"></i> Simpan</button>
                <a href="{{ route('mahasiswa.rpp.rencana-proyek.export') }}" class="btn btn-primary">
                    <i class="fas fa-file-word"></i> Ekspor RPP
                </a>
            </div>
        </div>
    </form>
</div>
