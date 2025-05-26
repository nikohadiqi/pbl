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
                @for($i = 0; $i < $oldCount; $i++) <tr>
                    <td><input type="text" name="fase[]" class="form-control" value="{{ old('fase.' . $i) }}"></td>
                    <td><input type="text" name="uraian_pekerjaan[]" class="form-control"
                            value="{{ old('uraian_pekerjaan.' . $i) }}"></td>
                    <td><input type="text" name="perkiraan_biaya[]" class="form-control"
                            value="{{ old('perkiraan_biaya.' . $i) }}"></td>
                    <td><input type="text" name="catatan[]" class="form-control" value="{{ old('catatan.' . $i) }}">
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endfor
                    @elseif(isset($biaya) && $biaya->count())
                    @foreach($biaya as $biaya)
                    <tr>
                        <td><input type="text" name="fase[]" class="form-control" value="{{ $biaya->fase }}"></td>
                        <td><input type="text" name="uraian_pekerjaan[]" class="form-control"
                                value="{{ $biaya->uraian_pekerjaan }}"></td>
                        <td><input type="text" name="perkiraan_biaya[]" class="form-control"
                                value="{{ $biaya->perkiraan_biaya }}"></td>
                        <td><input type="text" name="catatan[]" class="form-control" value="{{ $biaya->catatan }}"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td><input type="text" name="fase[]" class="form-control"></td>
                        <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
                        <td><input type="text" name="perkiraan_biaya[]" class="form-control"></td>
                        <td><input type="text" name="catatan[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
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
