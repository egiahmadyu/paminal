@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        select:hover, #datepicker:hover, #datepicker_tgl_kejadian:hover {
            cursor: pointer;
        }

    </style>
@endprepend

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-start">
            <li class="breadcrumb-item"><a href="/">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="#"> {{ $title }} </a> </li>
        </ol>
    </nav>

    @include('partials.message')
    <div class="row form-control">
        <div class="form-control text-center border-0">
            <h3 id="title_form">FORM {{ $title }}</h3>
        </div>
        <form action="/input-data-kasus/store" class="needs-validation" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <select class="form-select border-dark" aria-label="Default select example" name="tipe_data" id="tipe_data" required>
                        <option value="" selected disabled>PILIH TIPE ADUAN</option>
                        <option value="1" {{ old('tipe_data') == 1 ? 'selected' : '' }}>ADUAN MASYARAKAT</option>
                        @can('infosus-li')
                            <option value="2" {{ old('tipe_data') == 2 ? 'selected' : '' }}>INFO KHUSUS</option>
                            <option value="3" {{ old('tipe_data') == 3 ? 'selected' : '' }}>LAPORAN INFORMASI</option>
                        @endcan
                        
                    </select>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas" placeholder="NO. NOTA DINAS" value="{{ old('no_nota_dinas') ? old('no_nota_dinas') : '' }}" maxlength="50" disabled required>
                        <label for="no_nota_dinas">NO. NOTA DINAS</label>
                    </div>
                </div>
                
                <div class="col-lg-12 mb-3">
                    <center>
                        <div class="form-label">
                            <label for="check-box">TIPE PELANGGARAN</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="disiplin" name="jenis_wp" value="1" {{ old('jenis_wp') == 1 ? 'checked' : ''}} onchange='disiplinChange(this);' required>
                            <label class="form-check-label " for="disiplin">DISIPLIN</label>
                          </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="kode_etik" name="jenis_wp" value="2" {{ old('jenis_wp') == 2 ? 'checked' : ''}} onchange='kodeEtikChange(this);' required>
                            <label class="form-check-label" for="kode_etik">KODE ETIK</label>
                        </div>
                        <div class="invalid-feedback">Example invalid feedback text</div>
                    </center>
                </div>

                <div class="col-lg-12 mb-3">
                    <select class="form-select border-dark" aria-label="Default select example" name="wujud_perbuatan" id="wujud_perbuatan" disabled required style="height:100%">
                        <option value="">PILIH WUJUD PERBUATAN</option>
                    </select>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="Tanggal Nota Dinas" value="{{ old('tanggal_nota_dinas') ? old('tanggal_nota_dinas') : '' }}" readonly required>
                        <label for="tanggal_nota_dinas">TANGGAL NOTA DINAS</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <textarea class="form-control border-dark" name="perihal" placeholder="PERIHAL" id="perihal" value="{{ old('perihal') ? old('perihal') : '' }}" style="height: 150px" required></textarea>
                        <label for="perihal" class="form-label">PERIHAL</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating" id="den_bag" {{ old('den_bag') ? '' : 'hidden' }}>
                        <select class="form-select border-dark" aria-label="Default select example" name="den_bag">
                            <option value="">PILIH BAG / DETASEMEN</option>
                            @foreach ($bag_den as $bd)
                                <option value="{{ $bd->id }}" {{ old('den_bag') == $bd->id ? 'selected' : '' }}>{{ $bd->name }}</option>
                            @endforeach
                        </select>
                        <label for="den_bag" class="form-label">BAG / DETASEMEN</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating" id="unit_den_bag" hidden></div>
                </div>
                <hr>
            </div>
            <div class="row">
                <h4>PELAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="pelapor" id="pelapor" placeholder="Nama Pelapor" value="{{ old('pelapor') ? old('pelapor') : '' }}" required>
                                <label for="pelapor">Nama Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="number" class="form-control border-dark" name="umur" id="umur" placeholder="Umur Pelapor" value="{{ old('umur') ? old('umur') : '' }}" required>
                                <label for="umur">Umur</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @if (isset($jenis_kelamin))
                                        @foreach ($jenis_kelamin as $key => $jk)
                                            <option value="{{ $jk->id }}" {{ old('jenis_kelamin') == $jk->id ? 'selected' : '' }}>{{ $jk->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="pekerjaan" class="form-control border-dark" placeholder="Pekerjaan Pelapor" value="{{ old('pekerjaan') ? old('pekerjaan') : '' }}" required>
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            </div>
                           
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="agama" id="agama" required>
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach ($agama as $key => $ag)
                                        <option value="{{ $ag->id }}" {{ old('agama') == $ag->id ? 'selected' : '' }}>{{ $ag->name }}</option>
                                    @endforeach
                                </select>
                                <label for="agama" class="form-label">Agama</label>
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="no_identitas" id="no_identitas" placeholder="1234-5678-9012-1234" class="form-control border-dark" value="{{ old('no_identitas') ? old('no_identitas') : '' }}" required>
                                <label for="no_identitas" class="form-label">No Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas"id="jenis-identitas" required>
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    @if (isset($jenis_identitas))
                                        @foreach ($jenis_identitas as $key => $ji)
                                            <option value="{{ $ji->id }}" {{ old('jenis_identitas') == $ji->id ? 'selected' : '' }}>{{ $ji->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" name="no_telp" id="no_telp" placeholder="No. Telp Pelapor" class="form-control border-dark" value="{{ old('no_telp') ? old('no_telp') : '' }}" required>
                                <label for="no_telp" class="form-label">No. Telepon Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="alamat" placeholder="Alamat" id="floatingTextarea" value="{{ old('alamat') ? old('alamat') : '' }}" style="height: 160px" required></textarea>
                                <label for="floatingTextarea" class="form-label">Alamat</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>TERLAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP Terduga Pelanggar" value="{{ old('nrp') ? old('nrp') : '' }}" required>
                                <label for="nrp">NRP Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="terlapor" id="terlapor" placeholder="Nama Terduga Pelanggar" value="{{ old('terlapor') ? old('terlapor') : '' }}" required>
                                <label for="terlapor">Nama Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="pangkat" id="pangkat" required>
                                    <option value="">-- Pilih Pangkat --</option>
                                    @if (isset($pangkat))
                                        @foreach ($pangkat as $key => $p)
                                            <option value="{{ $p->id }}" {{ old('pangkat') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="pangkat" class="form-label">Pangkat Terduga Pelangar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan Terduga Pelanggar" value="{{ old('jabatan') ? old('jabatan') : '' }}" required>
                                <label for="jabatan">Jabatan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="kesatuan" id="kesatuan" placeholder="Kesatuan Terduga Pelanggar" value="{{ old('kesatuan') ? old('kesatuan') : '' }}" required>
                                <label for="kesatuan">Kesatuan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-control border-dark">
                                <select class="form-select" data-choices="true" data-live-search="true" aria-label="Default select example" name="wilayah_hukum" id="wilayah_hukum" required>
                                    <option value="" selected disabled>MABES / POLDA</option>
                                    @if (isset($wilayah_hukum))
                                        @foreach ($wilayah_hukum as $key => $wh)
                                            <option value="{{ $wh->id }}" {{ old('wilayah_hukum') == $wh->id ? 'selected' : '' }}>
                                                {{ $wh->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="tempat_kejadian" id="tempat_kejadian" placeholder="Tempat Kejadian" value="{{ old('tempat_kejadian') ? old('tempat_kejadian') : '' }}" required>
                                <label for="tempat_kejadian">Tempat Kejadian</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ old('tanggal_kejadian') ? old('tanggal_kejadian') : '' }}" readonly required>
                                <label for="tempat_kejadian">Tanggal Kejadian</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nama_korban" id="nama_korban" placeholder="Nama korban" value="{{ old('nama_korban') ? old('nama_korban') : '' }}" required>
                                <label for="nama_korban">Nama Korban</label>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 mb-3" id="kronologi_form">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="kronologis[]" placeholder="Kronologis" id="kronologis" value="{{ old('kronologis') ? old('kronologis') : '' }}" style="height: 160px" required></textarea>
                                <label for="kronologis" id="label_kronologi" class="form-label">Kronologis</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3" id="btn_add_kronologi" hidden>
                            <div class="col-lg-12 mb-3">
                                <button class="btn btn-success" id="add_kronologi">TAMBAH FAKTA-FAKTA</button>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3" id="catatan_form" hidden>
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="catatan[]" placeholder="" id="catatan" value="{{ old('catatan') ? old('catatan') : '' }}" style="height: 160px" required></textarea>
                                <label for="catatan" id="label_catatan" class="form-label">Catatan</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3" id="btn_add_catatan" hidden>
                            <div class="col-lg-12 mb-3">
                                <button class="btn btn-success" id="add_catatan">TAMBAH CATATAN</button>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <button class="btn btn-success form-control" type="submit" value="input_kasus" name="type_submit">
                                Submit Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </form>
          
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipe_data').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            //no identitas
            no_identitas.addEventListener('keyup', function(e){
                no_identitas.value = format_no_identitas(this.value, '');
            });

            function format_no_identitas(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 4,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{4}/gi);
                
                if(ribuan){
                    separator = sisa ? '-' : '';
                    rupiah += separator + ribuan.join('-');
                }
                
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
            };

            if ($('#disiplin').is(':checked')) {
                $('#wujud_perbuatan').removeAttr("disabled")
                $('#kode_etik').removeAttr("required")
                $('#kode_etik').attr("disabled")
                getValDisiplin()
            } else if (!$('#disiplin').is(':checked')) {
                $('#kode_etik').attr("required")
            }
            
            if ($('#kode_etik').is('checked')) {
                $('#wujud_perbuatan').removeAttr("disabled")
                $('#disiplin').attr("disabled")
                getValKodeEtik()
            }

            $('#add_kronologi').on('click', function() {
                let krono = `<div class="form-floating mt-3">
                                <textarea class="form-control border-dark" name="kronologis[]" placeholder="" id="kronologis" value="{{ old('kronologis') ? old('kronologis') : '' }}" style="height: 160px" required></textarea>
                                <label for="kronologis" class="form-label">Fakta-fakta</label>
                            </div>`
                $('#kronologi_form').append(krono)
            });

            $('#add_catatan').on('click', function() {
                let krono = ''
                if ($('#tipe_data').val() == 2) {
                    krono += `<div class="form-floating mt-3">
                                <textarea class="form-control border-dark" name="catatan[]" placeholder="CATATAN" id="catatan" value="{{ old('catatan') ? old('catatan') : '' }}" style="height: 160px" required></textarea>
                                <label for="catatan" class="form-label">Catatan</label>
                            </div>`
                } else if ($('#tipe_data').val() == 3) {
                    krono += `<div class="form-floating mt-3">
                                <textarea class="form-control border-dark" name="catatan[]" placeholder="CATATAN" id="catatan" value="{{ old('catatan') ? old('catatan') : '' }}" style="height: 160px" required></textarea>
                                <label for="catatan" class="form-label">Pendapat Pelapor</label>
                            </div>`
                }
                
                $('#catatan_form').append(krono)
            });

            $('#tipe_data').on('change', function() {
                
                if (this.value == 1) {
                    $('#no_nota_dinas').removeAttr('disabled')
                    $('#den_bag').prop('hidden', true)
                    $('#catatan_form').prop('hidden',true)
                    $('#btn_add_kronologi').prop('hidden',true)
                    $('#btn_add_catatan').prop('hidden',true)
                    $('#catatan').removeAttr('required')
                    $('#title_form').html('FORM INPUT ADUAN MASYARAKAT')
                } else if (this.value == 2) {
                    $('#no_nota_dinas').prop('disabled', true)
                    $('#no_nota_dinas').prop('required', true)
                    $('#den_bag').removeAttr('hidden')
                    $('#catatan_form').removeAttr('hidden')
                    $('#btn_add_kronologi').removeAttr('hidden')
                    $('#btn_add_catatan').removeAttr('hidden')
                    $('#title_form').html('FORM INPUT INFORMASI KHUSUS')
                    $('#label_kronologi').html('Fakta-fakta')
                } else {
                    $('#no_nota_dinas').prop('disabled', true)
                    $('#no_nota_dinas').prop('required', true)
                    $('#den_bag').removeAttr('hidden')
                    $('#catatan_form').removeAttr('hidden')
                    $('#btn_add_kronologi').removeAttr('hidden')
                    $('#btn_add_catatan').removeAttr('hidden')
                    $('#title_form').html('FORM INPUT LAMPORAN INFORMASI')
                    $('#label_kronologi').html('Fakta-fakta')
                    $('#label_catatan').html('Pendapat Pelapor')
                    $('#add_catatan').html('TAMBAH PENDAPAT PELAPOR')
                    add_catatan
                }
            });
            
            $('#den_bag').on('change', function() {
                let val = $('#den_bag').find(":selected").val()
                $.ajax({
                    url : 'api/get-unit/'+val,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $('.loading').css('display', 'block')
                    }, 
                    success: function (data, status, xhr) {
                        $('.loading').css('display', 'none')

                        let unit = Object.values(data.data.unit)
                        let option = ''
                        let html = ''
                        if (unit.length == 0) {
                            html = `<select class="form-select border-dark" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" disabled ><option value="">UNIT BELUM TERSEDIA</option></select><label for="unit_den_bag" class="form-label">UNIT</label>`
                        } else {
                            unit.forEach(element => {
                                let opt = `<option value="`+element.id+`">`+element.unit+`</option>`
                                option += opt
                            });
                            html = `<select class="form-select border-dark" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" required><option value="">PILIH UNIT</option>`+option+`</select><label for="unit_den_bag" class="form-label">UNIT</label>`
                        }
                        
                        $('#unit_den_bag').removeAttr('hidden')
                        $('#unit_den_bag').empty()
                        $('#unit_den_bag').append(html)
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback
                        $('.loading').css('display', 'none')
                        var option = {
                            title: 'Error',
                            text: 'Terjadi Kesalahan Sistem...',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }
                        Swal.fire(option) 
                    }
                })
            });
        });

        function disiplinChange(checkbox) {
            if(checkbox.checked == true){
                document.getElementById("wujud_perbuatan").removeAttribute("disabled");
                document.getElementById("kode_etik").removeAttribute("required");
                document.getElementById("kode_etik").setAttribute("disabled", "disabled");
                getValDisiplin()
            }else{
                document.getElementById("wujud_perbuatan").setAttribute("disabled", "disabled");
                document.getElementById("kode_etik").setAttribute("required", "required");
                document.getElementById("kode_etik").removeAttribute("disabled");
            }
        }

        function kodeEtikChange(checkbox) {
            if(checkbox.checked == true){
                document.getElementById("wujud_perbuatan").removeAttribute("disabled");
                document.getElementById("disiplin").removeAttribute("required");
                document.getElementById("disiplin").setAttribute("disabled", "disabled");
                getValKodeEtik()
            }else{
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

            // let html_wp = `<option value="">PILIH WUJUD PERBUATAN</option>`;
            let html_wp = ``;
            $('#wujud_perbuatan').append(html_wp);
            let is_selected = '';
            for (let index = 0; index < list_ketdis.length; index++) {
                const el_ketdis = list_ketdis[index];
                const el_id_dis = list_id_dis[index];
                if (kasus_wp != '' && kasus_wp == el_id_dis) {
                    is_selected = 'selected';
                }
                html_wp += `<option value="`+el_id_dis+`" `+is_selected+`>`+el_ketdis+`</option>`;
            }
            $('#wujud_perbuatan').append(html_wp);

            $('#wujud_perbuatan').select2({
                theme: "bootstrap-5"
            })
        }

        function getValKodeEtik() {
            let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
            let list_ketke = new Array();
            list_ketke = `{{ $kode_etik }}`;
            list_ketke = list_ketke.split('|');

            let list_id_ke = new Array();
            list_id_ke = `{{ $id_kode_etik }}`;
            list_id_ke = list_id_ke.split('|');

            let html_wp = ``;
            let is_selected = '';
            for (let index = 0; index < list_ketke.length; index++) {
                const el_ketke = list_ketke[index];
                const el_id_ke = list_id_ke[index];
                if (kasus_wp != '' && kasus_wp == el_id_ke) {
                    is_selected = 'selected';
                }
                html_wp += `<option value="`+el_id_ke+`" `+is_selected+`>`+el_ketke+`</option>`;
            }
            $('#wujud_perbuatan').append(html_wp);

            $('#wujud_perbuatan').select2({
                theme: "bootstrap-5"
            })
        }

        $( function() {
            $( "#datepicker" ).datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
                language: 'id'
            });
            $( "#datepicker_tgl_kejadian" ).datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
                language: 'id'
            });
        } );

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        $(function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
                })
        })
    </script>
@endsection
