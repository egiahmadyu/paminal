<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(1)">Sebelumnya</button>
            </div>
            <div>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="width:100%">
                    @foreach ($process as $proses)
                        <option value="{{ $proses->id }}">{{ $proses->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                @if ($kasus->status_id > 2)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <form action="{{ route('kasus.update.status') }}" method="post">
            @csrf
            <input type="text" class="form-control" id="kasus_id" name="data_pelanggar_id"
                value="{{ $kasus->id }}" hidden>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Disposisi</label>
                <select class="form-select" aria-label="Default select example" name="disposisi_tujuan"
                    {{ 2 != $kasus->status_id ? 'disabled' : '' }} onchange="getPolda()" id="disposisi-tujuan">
                    <option value="4">Pulbaket</option>
                    <option value="3" {{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah
                    </option>
                </select>
            </div>
            <div class="mb-3" id="limpah-polda">

            </div>
            <button type="submit" class="btn btn-primary"
                {{ 2 != $kasus->status_id ? 'disabled' : '' }}>Submit</button>
        </form>
    </div>
</div>
