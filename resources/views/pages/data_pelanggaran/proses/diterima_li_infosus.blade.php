<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
            </div>
            <div>

                @if ($kasus->status_id > 1)
                <button type="button" class="btn btn-primary" onclick="getViewProcess(4)">SELANJUTNYA <i class="far fa-arrow-right"></i></button>
                @endif

            </div>
        </div>
    </div>

    <!--Timeline-->
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 25%;">
                    </div>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>DITERIMA</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>PULBAKET</p>
                </div>
                <div class="f1-step">
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

    <!-- Isi -->
    <div class="col-lg-12">
        <form action="/data-kasus/update" method="post" id="form_input_data">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input type="text" class="form-control" value="4" hidden name="disposisi_tujuan">
            
            <div class="row">
                <!--Disposisi Button-->
                <div class="col-lg-12">
                    <div class="card p-2">
                        <div class="col-lg-12 mb-3">
                            <div class="row">

                                <!--Disposisi Karo/Sesro-->
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">DOKUMEN {{ $kasus->tipe_data == "2" ? 'INFORMASI KHUSUS' : 'LAPORAN INFORMASI' }}</label>
                                    <a href="/surat-li_infosus/{{ $kasus->id }}" class="btn btn-success" style="width: 100%">
                                        <i class="far fa-download"></i> Download
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <!--Disposisi Button-->
                @can('edit-diterima')
                    <div class="col-lg-12">
                        <div class="card p-2">
                            <div class="col-lg-12 mb-3">
                                <div class="row">

                                    <!--Disposisi Karo/Sesro-->
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">PERMOHONAN PENOMORAN SURAT {{ $kasus->tipe_data == 2 ? 'INFORMASI KHUSUS' : 'LAPORAN INFORMASI' }} KEPADA KARO/SESRO</label>
                                        @if (isset($disposisi[0]) && $disposisi[0]->tipe_disposisi == 1)
                                        <button class="btn btn-success" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="karosesro" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-download"></i> Download
                                        </button>
                                        @else
                                        <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal" data-bs-target="#modal_disposisi" id="karosesro" onclick="onClickModal(this)" type="button">
                                            <i class="far fa-plus-square"></i> Buat
                                        </button>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                
            </div>

            {{-- <button class="btn btn-success" name="type_submit" value="update_status">LANJUTKAN KE PULBAKET</button> --}}
            <!-- Submit data / Update status button -->
            {{-- <div class="row">
                <div class="col-lg-6">
                    <button class="btn btn-update-diterima btn-success" type="submit" value="update_data" name="type_submit">
                        <i class="far fa-upload"></i> LANJUTKAN KE PULBAKET
                    </button>
                </div>
            </div> --}}
            <button class="btn btn-update-diterima btn-info" type="submit" value="update_status" name="type_submit">
                <i class="far fa-upload"></i> LANJUTKAN KE PULBAKET
            </button>
        </form>
    </div>
</div>

<form action="/lembar-disposisi/{{ $kasus->id }}" method="post" id="form_dis_karo_binpam">
    @csrf
    <input type="hidden" name="limpah_den" id="limpah_den_input" value="">
    <input type="hidden" name="limpah_unit" id="limpah_unit_input" value="">
    <input type="hidden" name="nomor_agenda" value="{{ isset($disposisi[1]) ? $disposisi[1]['no_agenda'] : null }}">
    <input type="hidden" name="klasifikasi" value="{{ isset($disposisi[1]) ? $disposisi[1]['klasifikasi'] : null }}">
    <input type="hidden" name="derajat" value="{{ isset($disposisi[1]) ? $disposisi[1]['derajat'] : null }}">
    <input type="hidden" name="tipe_disposisi" id="tipe_disposisi" value="">
    {{-- <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Generate</button>
    </div> --}}
</form>

<!-- Modal Disposisi Karo/Sesro & Binpam-->
<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="modal_disposisi" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal_disposisi">PERMOHONAN PENOMORAN SURAT {{ $kasus->tipe_data == 2 ? 'INFORMASI KHUSUS' : 'LAPORAN INFORMASI' }} kepada Karo/Sesro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="getViewProcess(1)"></button>
            </div>
            <form action="/lembar-disposisi/{{ $kasus->id }}" method="post">
                @csrf
                <input type="hidden" name="tipe_data" value="{{ $kasus->tipe_data }}">
                <div class="modal-body">
                    <div class="form-floating mb-3" id="form_agenda">
                        <input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp" name="nomor_agenda" placeholder="NOMOR :" value="{{ !is_null($disposisi[2]['no_agenda']) ? $disposisi[2]['no_agenda'] : '' }}" {{ !is_null($disposisi[2]['no_agenda']) ? 'readonly' : '' }} autocomplete="off" required>
                        <label for="nomor_agenda" class="form-label">NOMOR :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="klasifikasi" id="klasifikasi" disabled required>
                            <option value="rahasia" selected> Rahasia</option>
                        </select>
                        <label for="klasifikasi" class="form-label">KLASIFIKASI</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select border-dark" aria-label="Default select example" name="derajat" id="derajat" disabled required>
                            <option value="Segera" selected>Segera</option>
                        </select>
                        <label for="derajat" class="form-label">DERAJAT</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark" id="surat_dari" aria-describedby="emailHelp" name="surat_dari" placeholder="SURAT DARI :" value="{{ $den_bag_pemohon->name }}" autocomplete="off" disabled>
                        <label for="surat_dari" class="form-label">SURAT DARI :</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control border-dark" name="perihal" placeholder="Perihal" id="perihal" value="{{ $kasus->tipe_data == 2 ? 'INFO KHUSUS' : 'LAPORAN INFORMASI' }}" style="height: 70px" autocomplete="off" disabled required>{{ $kasus->tipe_data == 2 ? 'INFO KHUSUS' : 'LAPORAN INFORMASI' }}</textarea>
                        <label for="perihal" class="form-label">Perihal</label>
                    </div>
                    <input type="number" value="3" hidden name="tipe_disposisi">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">GENERATE</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        checkStatusID()
        getPolda()
        let test = `{{ $kasus->perihal_nota_dinas }}`
        // console.log('masuk')

    });

    function checkStatusID() {
        let status_id = `{{ $kasus->status_id }}`
        if (status_id == 3) {
            $('#disposisi_kadena').hide();
        }
    }

    function limpahPolda() {
        $('#form_input_data').submit();
    }

    function onClickModal(modal) {
        let is_disabled = false;
        if (modal.id == 'karosesro') {
            $('#title_modal_disposisi').text('Permohonan penomoran surat {{ $kasus->tipe_data == 2 ? 'Informasi Khusus' : 'Laporan Informasi' }} kepada Karo/Sesro');
            let disabled = `{{ isset($disposisi[2]['no_agenda']) ? 'readonly' : '' }}`;
            console.log(disabled)

            let id_disposisi = `{{ isset($disposisi[2]) ? $disposisi[2]->id : ''}}`;

            if (id_disposisi > 0) {
                let no_agenda = `{{ isset($disposisi[2]) ? $disposisi[2]['no_agenda'] : ''}}`;
                
                let htmlNoAgenda = `<input type="text" class="form-control border-dark" id="nomor_agenda" aria-describedby="emailHelp"
                                name="nomor_agenda" placeholder="NOMOR SURAT :" value="` + no_agenda + `" `+disabled+` autocomplete="off" required>
                            <label for="nomor_agenda" class="form-label">NOMOR SURAT :</label>`;

                $('#form_agenda').html(htmlNoAgenda);
            }
        }
    }

    function disiplinChange(checkbox) {
        if (checkbox.checked == true) {
            document.getElementById("wujud_perbuatan").removeAttribute("disabled");
            document.getElementById("kode_etik").removeAttribute("required");
            document.getElementById("kode_etik").setAttribute("disabled", "disabled");
            getValDisiplin()
        } else {
            document.getElementById("wujud_perbuatan").setAttribute("disabled", "disabled");
            document.getElementById("kode_etik").setAttribute("required", "required");
            document.getElementById("kode_etik").removeAttribute("disabled");
        }
    }

    function kodeEtikChange(checkbox) {
        if (checkbox.checked == true) {
            document.getElementById("wujud_perbuatan").removeAttribute("disabled");
            document.getElementById("disiplin").removeAttribute("required");
            document.getElementById("disiplin").setAttribute("disabled", "disabled");
            getValKodeEtik()
        } else {
            document.getElementById("wujud_perbuatan").setAttribute("disabled", "disabled");
            document.getElementById("disiplin").setAttribute("required", "required");
            document.getElementById("disiplin").removeAttribute("disabled");
        }
    }

    function getValDisiplin() {
        let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
        let list_ketdis = new Array();
        list_ketdis = `{{ $disiplin }}`;
        list_ketdis = list_ketdis.split('|');

        let list_id_dis = new Array();
        list_id_dis = `{{ $id_disiplin }}`;
        list_id_dis = list_id_dis.split('|');

        let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
        for (let index = 0; index < list_ketdis.length; index++) {
            const el_ketdis = list_ketdis[index];
            const el_id_dis = list_id_dis[index];
            if (kasus_wp != '' && kasus_wp == el_id_dis) {
                html_wp += `<option value="` + el_id_dis + `" selected>` + el_ketdis + `</option>`;
            } else {
                html_wp += `<option value="` + el_id_dis + `">` + el_ketdis + `</option>`;
            }
        }
        $('#wujud_perbuatan').html(html_wp);
    }

    function getValKodeEtik() {
        let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
        let list_ketke = new Array();
        list_ketke = `{{ $kode_etik }}`;
        list_ketke = list_ketke.split('|');

        let list_id_ke = new Array();
        list_id_ke = `{{ $id_kode_etik }}`;
        list_id_ke = list_id_ke.split('|');

        let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
        for (let index = 0; index < list_ketke.length; index++) {
            const el_ketke = list_ketke[index];
            const el_id_ke = list_id_ke[index];
            if (kasus_wp != '' && kasus_wp == el_id_ke) {
                html_wp += `<option value="` + el_id_ke + `" selected>` + el_ketke + `</option>`;
            } else {
                html_wp += `<option value="` + el_id_ke + `">` + el_ketke + `</option>`;
            }
        }
        $('#wujud_perbuatan').html(html_wp);
    }

    $(function() {
        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'id'
        });
        $("#datepicker_tgl_kejadian").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'id'
        });
    });

    function getPolda(val) {
        let disposisi = $('#disposisi-tujuan').val() ? $('#disposisi-tujuan').val() : val
        if (disposisi == '3') {
            $.ajax({
                url: "/api/all-polda",
                method: "get"
            }).done(function(data) {
                console.log(data)
                $("#limpah-polda").html(data)
            });
        } else $("#limpah-polda").html("")
    }
</script>
