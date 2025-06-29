<div class="tab-pane fade {{ session('active_step') == 'step3' ? 'show active' : '' }}" id="step3" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.kebutuhan-peralatan.store') }}">
        @csrf
        <h4 class="mb-4">Kebutuhan Peralatan/Perangkat dan Bahan/Komponen</h4>

        <table class="table table-bordered" id="peralatan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Fase</th>
                    <th>Peralatan</th>
                    <th>Bahan</th>
                </tr>
            </thead>
            <tbody>
    @php $oldCount = count(old('nomor', [])); @endphp
    @if($oldCount > 0)
        @for($i = 0; $i < $oldCount; $i++)
        <tr>
            <td><input type="number" name="nomor[]" class="form-control" value="{{ old('nomor.' . $i) }}"></td>
            <td><textarea name="fase[]" class="form-control" rows="2">{{ old('fase.' . $i) }}</textarea></td>
            <td><textarea name="peralatan[]" class="form-control" rows="2">{{ old('peralatan.' . $i) }}</textarea></td>
            <td><textarea name="bahan[]" class="form-control" rows="2">{{ old('bahan.' . $i) }}</textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endfor
    @elseif(isset($kebutuhanPeralatan) && $kebutuhanPeralatan->count())
        @foreach($kebutuhanPeralatan as $item)
        <tr>
            <td><input type="number" name="nomor[]" class="form-control" value="{{ $item->nomor }}"></td>
            <td><textarea name="fase[]" class="form-control" rows="2">{{ $item->fase }}</textarea></td>
            <td><textarea name="peralatan[]" class="form-control" rows="2">{{ $item->peralatan }}</textarea></td>
            <td><textarea name="bahan[]" class="form-control" rows="2">{{ $item->bahan }}</textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endforeach
    @else
        <tr>
            <td><input type="number" name="nomor[]" class="form-control"></td>
            <td><textarea name="fase[]" class="form-control" rows="2"></textarea></td>
            <td><textarea name="peralatan[]" class="form-control" rows="2"></textarea></td>
            <td><textarea name="bahan[]" class="form-control" rows="2"></textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
    @endif
</tbody>

        </table>

        <button type="button" class="btn btn-sm btn-success mb-4" onclick="addPeralatanRow()">+ Tambah
            Peralatan</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step2">Previous</button>
            <div>
                <button type="submit" class="btn btn-success me-3"><i class="bi bi-floppy me-1"></i> Simpan</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step4">Next</button>
            </div>
        </div>
    </form>
</div>
