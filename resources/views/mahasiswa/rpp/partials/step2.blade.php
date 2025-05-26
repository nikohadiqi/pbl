<div class="tab-pane fade {{ session('active_step') == 'step2' ? 'show active' : '' }}" id="step2" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.tahapan-pelaksanaan.store') }}">
        @csrf
        <h4 class="mb-4">Tahapan Pelaksanaan Proyek</h4>

        <table class="table table-bordered" id="tahapan-table">
            <thead>
                <tr>
                    <th>Minggu</th>
                    <th>Tahapan</th>
                    <th>PIC</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $oldCount = count(old('minggu', [])); @endphp
                @if($oldCount > 0)
                @for($i = 0; $i < $oldCount; $i++) <tr>
                    <td><input type="number" name="minggu[]" class="form-control" value="{{ old('minggu.' . $i) }}">
                    </td>
                    <td><input type="text" name="tahapan[]" class="form-control" value="{{ old('tahapan.' . $i) }}">
                    </td>
                    <td><input type="text" name="pic[]" class="form-control" value="{{ old('pic.' . $i) }}"></td>
                    <td><input type="text" name="keterangan[]" class="form-control"
                            value="{{ old('keterangan.' . $i) }}"></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endfor
                    @elseif(isset($tahapanPelaksanaan) && $tahapanPelaksanaan->count())
                    @foreach($tahapanPelaksanaan as $tahapan)
                    <tr>
                        <td><input type="number" name="minggu[]" class="form-control" value="{{ $tahapan->minggu }}">
                        </td>
                        <td><input type="text" name="tahapan[]" class="form-control" value="{{ $tahapan->tahapan }}">
                        </td>
                        <td><input type="text" name="pic[]" class="form-control" value="{{ $tahapan->pic }}"></td>
                        <td><input type="text" name="keterangan[]" class="form-control"
                                value="{{ $tahapan->keterangan }}"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td><input type="number" name="minggu[]" class="form-control"></td>
                        <td><input type="text" name="tahapan[]" class="form-control"></td>
                        <td><input type="text" name="pic[]" class="form-control"></td>
                        <td><input type="text" name="keterangan[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endif
            </tbody>
        </table>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTahapanRow()">+ Tambah Tahapan</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step1">Previous</button>
            <div>
                <button type="submit" class="btn btn-success me-3"><i class="bi bi-floppy me-1"></i> Simpan</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step3">Next</button>
            </div>
        </div>
    </form>
</div>
