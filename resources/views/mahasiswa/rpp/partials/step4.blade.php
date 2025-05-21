<div class="tab-pane fade {{ session('active_step') == 'step4' ? 'show active' : '' }}" id="step4" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.tantangan.store') }}">
        @csrf
        <h4 class="mb-4">Tantangan dan Isu</h4>

        <table class="table table-bordered" id="tantangan-table">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Proses</th>
                    <th>Isu</th>
                    <th>Level Resiko</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php $oldCount = count(old('nomor', [])); @endphp
                @if($oldCount > 0)
                @for($i = 0; $i < $oldCount; $i++) <tr>
                    <td><input type="number" name="nomor[]" class="form-control" value="{{ old('nomor.' . $i) }}"></td>
                    <td><input type="text" name="proses[]" class="form-control" value="{{ old('proses.' . $i) }}"></td>
                    <td><input type="text" name="isu[]" class="form-control" value="{{ old('isu.' . $i) }}"></td>
                    <td>
                        <select name="level_resiko[]" class="form-control">
                            <option value="" disabled {{ old('level_resiko.' . $i) ? '' : 'selected' }}>-- Pilih Level --
                            </option>
                            <option value="H" {{ old('level_resiko.' . $i)=='H' ? 'selected' : '' }}>H</option>
                            <option value="M" {{ old('level_resiko.' . $i)=='M' ? 'selected' : '' }}>M</option>
                            <option value="L" {{ old('level_resiko.' . $i)=='L' ? 'selected' : '' }}>L</option>
                        </select>
                    </td>
                    <td><input type="text" name="catatan[]" class="form-control" value="{{ old('catatan.' . $i) }}">
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button>
                    </td>
                    </tr>
                    @endfor
                    @elseif(isset($tantangan) && $tantangan->count())
                    @foreach($tantangan as $item)
                    <tr>
                        <td><input type="number" name="nomor[]" class="form-control" value="{{ $item->nomor }}"></td>
                        <td><input type="text" name="proses[]" class="form-control" value="{{ $item->proses }}"></td>
                        <td><input type="text" name="isu[]" class="form-control" value="{{ $item->isu }}"></td>
                        <td>
                            <select name="level_resiko[]" class="form-control">
                                <option value="" disabled {{ $item->level_resiko ? '' : 'selected' }}>-- Pilih Level --
                                </option>
                                <option value="H" {{ $item->level_resiko == 'H' ? 'selected' : '' }}>H</option>
                                <option value="M" {{ $item->level_resiko == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ $item->level_resiko == 'L' ? 'selected' : '' }}>L</option>
                            </select>
                        </td>
                        <td><input type="text" name="catatan[]" class="form-control" value="{{ $item->catatan }}"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td><input type="number" name="nomor[]" class="form-control"></td>
                        <td><input type="text" name="proses[]" class="form-control"></td>
                        <td><input type="text" name="isu[]" class="form-control"></td>
                        <td>
                            <select name="level_resiko[]" class="form-control">
                                <option value="" selected disabled>-- Pilih Level --</option>
                                <option value="H">H</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                            </select>
                        </td>
                        <td><input type="text" name="catatan[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button>
                        </td>
                    </tr>
                    @endif
            </tbody>
        </table>
        <p class="mt-2 text-muted small"><strong>Keterangan:</strong> H: High; M: Medium; L: Low</p>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTantanganRow()">+ Tambah
            Tantangan</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step3">Previous</button>
            <div>
                <button type="submit" class="btn btn-success me-3">Simpan</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step5">Next</button>
            </div>
        </div>
    </form>
</div>
