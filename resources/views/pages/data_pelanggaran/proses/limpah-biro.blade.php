<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-info" onclick="getViewProcess(5)"><i class="far fa-arrow-left"></i> SEBELUMNYA</button>
            </div>
            <div>

            </div>
        </div>
    </div>

    <!--Timeline-->
    <div class="row">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-dark">
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
                                    <td>PELIMPAHAN</td>
                                    <td>:</td>
                                    <td>{{ $jenis_limpah }}</td>
                                </tr>
                                <tr>
                                    <td>USIA DUMAS</td>
                                    <td>:</td>
                                    <td>{{ $usia_dumas }}</td>
                                </tr>
                                <tr>
                                    <td>PERIHAL</td>
                                    <td>:</td>
                                    <td>{{ $kasus->perihal_nota_dinas }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                
                                <tr>
                                    <td>UNIT PELAKSANA</td>
                                    <td>:</td>
                                    <td>{{ $unit }}</td>
                                </tr>
                                <tr>
                                    <td>KETUA TIM</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($penyidik[0]->pangkat.' '.$penyidik[0]->name.' / '.$penyidik[0]->nrp) }}</td>
                                </tr>
                                <tr>
                                    <td>PIMPINAN GELAR PERKARA</td>
                                    <td>:</td>
                                    <td>{{ $pimpinan_gelar }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL GELAR PERKARA</td>
                                    <td>:</td>
                                    <td>{{ Carbon\Carbon::parse($gelar_perkara->tanggal)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>TEMPAT GELAR PERKARA</td>
                                    <td>:</td>
                                    <td>{{ $gelar_perkara->tempat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Isi -->
    @can('edit-limpah_biro')
        <div class="row">
            <div class="col-lg-12">
                <div class="row mv-3">
                    <div class="col-lg-12 mb-3">
                        <input type="text" id="kasus_id" value="{{ $kasus->id }}" hidden>
                        <form action="/limpah-biro/{{ $kasus->id }}" method="post">
                            @csrf
                            @if ($limpah_biro->jenis_limpah == 3)
                                @if (!is_null($limpah_biro->limpah_polda))
                                    <div class="form-buat-surat col-lg-12">
                                        <label for="download_laporan_limpah_biro" class="form-label">LAPORAN LIMPAH :</label>
                                        <a href="/laporan-hasil-limpah-biro/{{ $kasus->id }}"
                                            class="form-control btn btn-outline-primary text-primary">
                                            <h6 class="p-0 m-0"><i class="far fa-download"></i> DOKUMEN</h6>
                                        </a>
                                    </div>
                                @else
                                    <div class="form-buat-surat col-lg-12 mb-3 mt-3">
                                        {{-- <label for="tgl_pembuatan_surat_perintah" class="form-label"></label> --}}
                                        <select class="form-select border-dark" aria-label="Default select example" name="limpah_polda" id="limpah_polda" required>
                                                <option value="" class="text-center">PILIH PELIMPAHAN POLDA</option>
                                                @if (isset($polda))
                                                    @foreach ($polda as $p)
                                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                    @endforeach
                                                @endif
                                        </select>
                                    </div>
                                    <div class="form-buat-surat col-lg-12 mb-3">
                                        <button type="submit" class="form-control btn btn-outline-primary text-primary">
                                            <h6 class="p-0 m-0">SUBMIT</h6>
                                        </button>
                                    </div>
                                @endif
                                
                            @else
                                <div class="form-buat-surat col-lg-12">
                                    <label for="download_laporan_limpah_biro" class="form-label">LAPORAN LIMPAH :</label>
                                    <a href="/laporan-hasil-limpah-biro/{{ $kasus->id }}"
                                        class="form-control btn btn-outline-primary text-primary">
                                        <h6 class="p-0 m-0"><i class="far fa-download"></i> DOKUMEN</h6>
                                    </a>
                                </div>
                            @endif
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    
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
