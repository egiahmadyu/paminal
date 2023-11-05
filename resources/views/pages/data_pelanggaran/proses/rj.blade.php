<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(5)"><i class="far fa-arrow-left"></i> Sebelumnya</button>
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
                <div class="f1-step active">
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
                        <h1>ADUAN DIHENTIKAN DENGAN STATUS RESTORATIVE JUSTICE</h1>
                    </center>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td> NO. SPRIN </td>
                                    <td>:</td>
                                    <td>
                                        @if (isset($sprin))
                                            SPRIN/{{ $sprin->no_sprin }}/HUK.6.6./2023
                                        @else 
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>PELAPOR</td>
                                    <td> : </td>
                                    <td>{{ strtoupper($kasus->pelapor) }}</td>
                                </tr>
                                <tr>
                                    <td>TERDUGA TERLAPOR</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($terlapor) }} / {{ $kasus->nrp }}</td>
                                </tr>
                                <tr>
                                    <td>USIA DUMAS</td>
                                    <td>:</td>
                                    <td>{{ $usia_dumas }}</td>
                                </tr>
                                <tr>
                                    <td>PERIHAL</td>
                                    <td>:</td>
                                    <td>{{ $kasus->tipe == 1 ? $kasus->perihal_nota_dinas : ($kasus->tipe == 2 ? 'INFORMASI KHUSUS' : 'LAPORAN INFORMASI') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td>UNIT PELAKSANA</td>
                                    <td>:</td>
                                    <td>{{ $unit }} {{ $den }}</td>
                                </tr>
                                <tr>
                                    <td>KETUA TIM</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($penyidik[0]->pangkat.' '.$penyidik[0]->name.' / '.$penyidik[0]->nrp) }}</td>
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


{{-- Modal --}}
<div class="modal fade" id="modal_sprin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PEMBUATAN SURAT PERINTAH</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(6)"></button>
            </div>
            <div class="modal-body">
                <form action="/surat-perintah/{{ $kasus->id }}">
                    <div class="form-outline mb-3">
                        <label class="form-label" for="textAreaExample2">ISI SURAT</label>
                        <textarea class="form-control" name="isi_surat_perintah" rows="8"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">BUAT SURAT/button>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button> --}}
                <button type="button" class="btn btn-primary">SIMPAN</button>
            </div>
        </div>
    </div>
</div>


<script>
    // $(document).ready(function() {
    //     getNextData()
    // });

    // function getNextData() {
    //     console.log($('#test_sprin').val())
    //     if ($('#test_sprin').val() == 'done') {

    //         $.ajax({
    //             url: `/pulbaket/view/next-data/` + $('#kasus_id').val(),
    //             method: "get"
    //         }).done(function(data) {
    //             $('.loader-view').css("display", "none");
    //             $("#viewNext").html(data)
    //         });
    //     }
    // }
</script>
