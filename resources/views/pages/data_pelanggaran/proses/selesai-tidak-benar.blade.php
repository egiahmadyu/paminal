<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(1)"><i class="far fa-arrow-left"></i> SEBELUMNYA</button>
            </div>
            <div>

            </div>
        </div>
    </div>

    <!--Timeline-->
    <div class="row mb-3">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 100%;">
                    </div>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>DITERIMA</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>PULBAKET</p>
                </div>
                <div class="f1-step ">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>GELAR PERKARA</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                    <p>LIMPAH</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card border-dark">
                <div class="card-header">
                    <center>
                        <h1>ADUAN DISELESAIKAN DENGAN STATUS SELESAI TIDAK BENAR</h1>
                    </center>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td>PELAPOR</td>
                                    <td> : </td>
                                    <td>{{ strtoupper($kasus->pelapor) }}</td>
                                </tr>
                                <tr>
                                    <td>TERDUGA TERLAPOR</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($terlapor) }} / {{ $kasus->nrp ? $kasus->nrp : 'TIDAK TAHU' }}</td>
                                </tr>
                                <tr>
                                    <td>PERIHAL</td>
                                    <td>:</td>
                                    @if ($kasus->tipe)
                                        <td>{{ $kasus->tipe == 1 ? $kasus->perihal_nota_dinas : ($kasus->tipe == 2 ? 'INFORMASI KHUSUS' : 'LAPORAN INFORMASI') }}</td>
                                    @else
                                        <td>TIDAK ADA</td>
                                    @endif
                                   
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Isi -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row mv-3">
                <div class="col-lg-12 mb-3">
                </div>
            </div>
        </div>
    </div>

</div>