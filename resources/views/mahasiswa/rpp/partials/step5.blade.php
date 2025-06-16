<div class="tab-pane fade {{ session('active_step') == 'step5' ? 'show active' : '' }}" id="step5" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.biaya.store') }}">
        @csrf
        <h4 class="mb-4">Biaya Proyek (Biaya Bahan dan Peralatan)</h4>

        <table class="table table-bordered" id="biaya-table">
            <thead>
                <tr>
                    <th>Fase</th>
                    <th>Uraian Pekerjaan</th>
                    <th>Perkiraan Biaya</th>
                    <th>Catatan</th>
                </tr>
            </thead>
<tbody>
    @php $oldCount = count(old('fase', [])); @endphp
    @if($oldCount > 0)
        @for($i = 0; $i < $oldCount; $i++)
        <tr>
            <td><textarea name="fase[]" class="form-control" rows="2">{{ old('fase.' . $i) }}</textarea></td>
            <td><textarea name="uraian_pekerjaan[]" class="form-control" rows="2">{{ old('uraian_pekerjaan.' . $i) }}</textarea></td>
            <td><textarea name="perkiraan_biaya[]" class="form-control" rows="2">{{ old('perkiraan_biaya.' . $i) }}</textarea></td>
            <td><textarea name="catatan[]" class="form-control" rows="2">{{ old('catatan.' . $i) }}</textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endfor
    @elseif(isset($biaya) && $biaya->count())
        @foreach($biaya as $item)
        <tr>
            <td><textarea name="fase[]" class="form-control" rows="2">{{ $item->fase }}</textarea></td>
            <td><textarea name="uraian_pekerjaan[]" class="form-control" rows="2">{{ $item->uraian_pekerjaan }}</textarea></td>
            <td><textarea name="perkiraan_biaya[]" class="form-control" rows="2">{{ $item->perkiraan_biaya }}</textarea></td>
            <td><textarea name="catatan[]" class="form-control" rows="2">{{ $item->catatan }}</textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endforeach
    @else
        <tr>
<tbody>
    @php $oldCount = count(old('fase', [])); @endphp
    @if($oldCount > 0)
        @for($i = 0; $i < $oldCount; $i++)
        <tr>
            <td><textarea name="fase[]" class="form-control" rows="2">{{ old('fase.' . $i) }}</textarea></td>
            <td><textarea name="uraian_pekerjaan[]" class="form-control" rows="2">{{ old('uraian_pekerjaan.' . $i) }}</textarea></td>
            <td><textarea name="perkiraan_biaya[]" class="form-control" rows="2">{{ old('perkiraan_biaya.' . $i) }}</textarea></td>
            <td><textarea name="catatan[]" class="form-control" rows="2">{{ old('catatan.' . $i) }}</textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endfor
    @elseif(isset($biaya) && $biaya->count())
        @foreach($biaya as $item)
        <tr>
            <td><textarea name="fase[]" class="form-control" rows="2">{{ $item->fase }}</textarea></td>
            <td><textarea name="uraian_pekerjaan[]" class="form-control" rows="2">{{ $item->uraian_pekerjaan }}</textarea></td>
            <td><textarea name="perkiraan_biaya[]" class="form-control" rows="2">{{ $item->perkiraan_biaya }}</textarea></td>
            <td><textarea name="catatan[]" class="form-control" rows="2">{{ $item->catatan }}</textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endforeach
    @else
        <tr>
            <td><textarea name="fase[]" class="form-control" rows="2"></textarea></td>
            <td><textarea name="uraian_pekerjaan[]" class="form-control" rows="2"></textarea></td>
            <td><textarea name="perkiraan_biaya[]" class="form-control" rows="2"></textarea></td>
            <td><textarea name="catatan[]" class="form-control" rows="2"></textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        </tr>
    @endif
</tbody>

        </tr>
    @endif
</tbody>
        </table>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addBiayaRow()">+ Tambah Biaya</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step4">Previous</button>
            <div>
                <button type="submit" class="btn btn-success me-3"><i class="bi bi-floppy me-1"></i> Simpan</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step6">Next</button>
            </div>
        </div>
    </form>
</div>
