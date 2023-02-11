<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="width:100%">
                    @foreach ($process as $proses)
                        <option value="{{ $proses->id }}">{{ $proses->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="getViewProcess(2)">Selanjutnya</button>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4">
                <label for="exampleFormControlInput1" class="form-label">Pelapor</label>
                <input type="text" class="form-control" value="{{ $kasus->pelapor }}" readonly>
            </div>
            <div class="col-lg-4">
                <label for="exampleFormControlInput1" class="form-label">Terlapor</label>
                <input type="text" class="form-control" value="{{ $kasus->terlapor }}" readonly>
            </div>
        </div>
    </div>
</div>
