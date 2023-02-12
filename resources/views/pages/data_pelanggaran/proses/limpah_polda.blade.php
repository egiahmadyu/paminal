<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(2)">Sebelumnya</button>
            </div>
            <div>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="width:100%">
                    @foreach ($process as $proses)
                        <option value="{{ $proses->id }}">{{ $proses->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                {{-- @if ($kasus->status_id > 2)
                    <button type="button" class="btn btn-info" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="75" data-number-of-steps="2" style="width: 75%;">
                    </div>
                </div>
                <div class="f1-step" style="width: 50%;">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>Diterima</p>
                </div>
                <div class="f1-step active" style="width: 50%;">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Limpah Polda</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <h4>Limpah Ke Polda</h4>
        <form action="">
            <div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Polda / Sederajat</label>
                        <input type="text" class="form-control" id="polda_limpah" readonly
                            value="{{ $limpahPolda->polda->name }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Limpah</label>
                        <input type="text" class="form-control" readonly value="{{ $limpahPolda->tanggal_limpah }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Pelimpah</label>
                        <input type="text" class="form-control" readonly value="{{ $limpahPolda->user->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        {{-- <div id="toolbar-container"></div> --}}
                        {{-- <div id="editor">
                            @include('pages.data_pelanggaran.generate.limpah-polda')
                        </div> --}}
                    </div>

                </div>
                <a href="/pdf-test"><button type="button" class="btn btn-primary">Generate Surat
                        Limpah</button></a>

            </div>
        </form>
    </div>
</div>
