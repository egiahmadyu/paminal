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
        <form action="/input-data-kasus/store" class="needs-validation" method="post" novalidate>
            @csrf
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <label for="tipe_data" class="form-label">TIPE ADUAN</label>
                    <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="tipe_data" id="tipe_data" required>
                        <option value="">PILIH TIPE ADUAN</option>
                        @can('input-dumas')
                            <option value="1" {{ old('tipe_data') == 1 ? 'selected' : '' }}>ADUAN MASYARAKAT</option>
                        @endcan
                        @can('infosus-li')
                            <option value="2" {{ old('tipe_data') == 2 ? 'selected' : '' }}>INFO KHUSUS</option>
                            <option value="3" {{ old('tipe_data') == 3 ? 'selected' : '' }}>LAPORAN INFORMASI</option>
                        @endcan
                    </select>
                    <div class="invalid-feedback">MOHON ISI TIPE ADUAN</div>
                    <div class="valid-feedback">OK !</div>  
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="no_nota_dinas" class="form-label">NO. NOTA DINAS</label>
                    <input type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas" placeholder="NO. NOTA DINAS" value="{{ old('no_nota_dinas') ? old('no_nota_dinas') : '' }}" maxlength="50" disabled>
                    <div class="invalid-feedback">
                        MOHON ISI NO. NOTA DINAS !
                    </div>
                </div>
                
                <div class="col-lg-12 mb-3">
                    <center>
                        <div class="form-label">
                            <label for="check-box">TIPE PELANGGARAN</label>
                            <div class="invalid-feedback">
                                MOHON PILIH TIPE PELANGGARAN !
                            </div>
                            
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="disiplin" name="jenis_wp" value="1" {{ old('jenis_wp') == 1 ? 'checked' : ''}} onchange='disiplinChange(this);' required>
                            <label class="form-check-label " for="disiplin">DISIPLIN</label>
                          </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="kode_etik" name="jenis_wp" value="2" {{ old('jenis_wp') == 2 ? 'checked' : ''}} onchange='kodeEtikChange(this);' required>
                            <label class="form-check-label" for="kode_etik">KODE ETIK</label>
                        </div>
                        
                    </center>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="wujud_perbuatan" class="form-label">WUJUD PERBUATAN</label>
                    <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="wujud_perbuatan" id="wujud_perbuatan" disabled required>
                        <option value="">PILIH WUJUD PERBUATAN</option>
                    </select>
                    <div class="invalid-feedback">
                        MOHON PILIH WUJUD PERBUATAN !
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="tanggal_nota_dinas" class="form-label">TANGGAL NOTA DINAS</label>
                    <input type="text" data-live-search="true" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="DD/MM/YYYY" required value="{{ old('tanggal_nota_dinas') ? old('tanggal_nota_dinas') : '' }}">
                    <div class="invalid-feedback">
                        MOHON PILIH TANGGAL NOTA DINAS !
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="perihal" class="form-label">PERIHAL ADUAN</label>
                    <textarea class="form-control border-dark" name="perihal" placeholder="PERIHAL" id="perihal" value="{{ old('perihal') ? old('perihal') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 150px"  required></textarea>
                    <div class="invalid-feedback">
                        MOHON ISI PERIHAL ADUAN !
                    </div>
                </div>

                <div class="col-lg-12 mb-3" id="form_den_bag" hidden>
                    <label for="den_bag" class="form-label">BAG / DETASEMEN</label>
                    <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="den_bag" id="den_bag">
                        <option value="" disabled selected>PILIH BAG / DETASEMEN</option>
                        @foreach ($bag_den as $bd)
                            <option value="{{ $bd->id }}" {{ old('den_bag') == $bd->id ? 'selected' : '' }}>{{ $bd->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        MOHON PILIH BAG / DETASEMEN !
                    </div>
                </div>

                <div class="col-lg-12 mb-3" id="unit_den_bag" hidden>
                </div>
                <hr>
            </div>
            <div class="row">
                <h4>PELAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="pelapor" class="form-label">NAMA</label>
                            <input type="text" class="form-control border-dark" name="pelapor" id="pelapor" placeholder="NAMA" value="{{ old('pelapor') ? old('pelapor') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NAMA PELAPOR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="umur" class="form-label">UMUR</label>
                            <input type="number" class="form-control border-dark" name="umur" id="umur" placeholder="UMUR" value="{{ old('umur') ? old('umur') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI UMUR PELAPOR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">JENIS KELAMIN</label>
                            <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="" selected disabled>PILIH JENIS KELAMIN</option>
                                @if (isset($jenis_kelamin))
                                    @foreach ($jenis_kelamin as $key => $jk)
                                        <option value="{{ $jk->id }}" {{ old('jenis_kelamin') == $jk->id ? 'selected' : '' }}>{{ strtoupper($jk->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH JENIS KELAMIN PELAPOR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="pekerjaan" class="form-label">PEKERJAAN</label>
                            <input type="text" name="pekerjaan" class="form-control border-dark" placeholder="PEKERJAAN" value="{{ old('pekerjaan') ? old('pekerjaan') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI PEKERJAAN PELAPOR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="agama" class="form-label">AGAMA</label>
                            <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="agama" id="agama" required>
                                <option value="" selected disabled>PILIH AGAMA</option>
                                @foreach ($agama as $key => $ag)
                                    <option value="{{ $ag->id }}" {{ old('agama') == $ag->id ? 'selected' : '' }}>{{ strtoupper($ag->name) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH AGAMA PELAPOR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="no_identitas" class="form-label">NO. IDENTITAS</label>
                            <input type="text" name="no_identitas" id="no_identitas" placeholder="contoh : 0000-1234-4321-9999" maxlength="20" class="form-control border-dark" value="{{ old('no_identitas') ? old('no_identitas') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NO. IDENTITAS !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jenis_identitas" class="form-label">JENIS IDENTITAS</label>
                            <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="jenis_identitas"id="jenis_identitas" required>
                                <option value="" selected disabled>PILIH JENIS IDENTITAS</option>
                                @if (isset($jenis_identitas))
                                    @foreach ($jenis_identitas as $key => $ji)
                                        <option value="{{ $ji->id }}" {{ old('jenis_identitas') == $ji->id ? 'selected' : '' }}>{{ $ji->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH JENIS IDENTITAS !
                            </div>
                            
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="no_telp" class="form-label">NO. TELEPON</label>
                            <input type="text" name="no_telp" maxlength="18" id="no_telp" placeholder="contoh: 0888-1234-9999" class="form-control border-dark" value="{{ old('no_telp') ? old('no_telp') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NO. TELEPON PELAPOR !
                            </div>
                            
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="floatingTextarea" class="form-label">ALAMAT LENGKAP</label>
                            <textarea class="form-control border-dark" name="alamat" placeholder="ALAMAT" id="floatingTextarea" value="{{ old('alamat') ? old('alamat') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 160px" required></textarea>
                            <div class="invalid-feedback">
                                MOHON ISI ALAMAT PELAPOR !
                            </div>
                            
                        </div>
                    </div>
                </div>
                <hr>
                <h4>TERLAPOR</h4>
                <div class="col-lg-12 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="nrp" class="form-label">NRP</label>
                            <input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP" value="{{ old('nrp') ? old('nrp') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NRP TERDUGA PELANGGAR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="terlapor" class="form-label">NAMA</label>
                            <input type="text" class="form-control border-dark" name="terlapor" id="terlapor" placeholder="NAMA" value="{{ old('terlapor') ? old('terlapor') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NAMA TERDUGA PELANGGAR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="pangkat" class="form-label">PANGKAT</label>
                            <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="pangkat" id="pangkat" required>
                                <option value="" selected disabled>PILIH PANGKAT</option>
                                @if (isset($pangkat))
                                    @foreach ($pangkat as $key => $p)
                                        <option value="{{ $p->id }}" {{ old('pangkat') == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH PANGKAT TERDUGA PELANGGAR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jabatan" class="form-label">JABATAN</label>
                            <input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="JABATAN" value="{{ old('jabatan') ? old('jabatan') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI JABATAN TERDUGA PELANGGAR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="kesatuan" class="form-label">KESATUAN</label>
                            <input type="text" class="form-control border-dark" name="kesatuan" id="kesatuan" placeholder="KESATUAN" value="{{ old('kesatuan') ? old('kesatuan') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI KESATUAN TERDUGA PELANGGAR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="wilayah_hukum" class="form-label">WILAYAH HUKUM</label>
                            <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="wilayah_hukum" id="wilayah_hukum" required>
                                <option value="" selected disabled>MABES / POLDA</option>
                                @if (isset($wilayah_hukum))
                                    @foreach ($wilayah_hukum as $key => $wh)
                                        <option value="{{ $wh->id }}" {{ old('wilayah_hukum') == $wh->id ? 'selected' : '' }}>
                                            {{ $wh->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                MOHON PILIH WILAYAH HUKUM TERDUGA PELANGGAR !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="tempat_kejadian" class="form-label">TEMPAT KEJADIAN</label>
                            <input type="text" class="form-control border-dark" name="tempat_kejadian" id="tempat_kejadian" placeholder="TEMPAT KEJADIAN" value="{{ old('tempat_kejadian') ? old('tempat_kejadian') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI TEMPAT KEJADIAN PELANGGARAN !
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="tempat_kejadian" class="form-label">TANGGAL KEJADIAN</label>
                            <input type="text" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="DD/MM/YYYY" value="{{ old('tanggal_kejadian') ? old('tanggal_kejadian') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON PILIH TANGGAL KEJADIAN PELANGGARAN !
                            </div>
                            
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="nama_korban" class="form-label">NAMA KORBAN</label>
                            <input type="text" class="form-control border-dark" name="nama_korban" id="nama_korban" placeholder="NAMA KORBAN" value="{{ old('nama_korban') ? old('nama_korban') : '' }}" required>
                            <div class="invalid-feedback">
                                MOHON ISI NAMA KORBAN !
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-12 mb-3" id="kronologi_form">
                            <label for="kronologis" id="label_kronologi" class="form-label">KRONOLOGIS</label>
                            <textarea class="form-control border-dark" name="kronologis[]" placeholder="Kronologis" id="kronologis" value="{{ old('kronologis') ? old('kronologis') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 300px" required></textarea>
                            <div class="invalid-feedback">
                                MOHON ISI KRONOLOGIS PELANGGARAN !
                            </div>
                            
                        </div>

                        <div class="col-lg-12 mb-3" id="btn_add_kronologi" hidden>
                            <div class="col-lg-12 mb-3">
                                <button class="btn btn-success" id="add_kronologi">TAMBAH FAKTA-FAKTA</button>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3" id="catatan_form" hidden>
                            <label for="catatan" id="label_catatan" class="form-label">CATATAN</label>
                            <textarea class="form-control border-dark" name="catatan[]" placeholder="" id="catatan" value="{{ old('catatan') ? old('catatan') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 160px" ></textarea>
                            <div class="invalid-feedback">
                                MOHON ISI CATATAN PELANGGARAN !
                            </div>
                            
                        </div>

                        <div class="col-lg-12 mb-3" id="btn_add_catatan" hidden>
                            <div class="col-lg-12 mb-3">
                                <button class="btn btn-success" id="add_catatan">TAMBAH CATATAN</button>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <button class="btn btn-success form-control" type="submit" value="input_kasus" name="type_submit">
                                SUBMIT DATA
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
            
            $('#wilayah_hukum').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            $('#pangkat').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            $('#agama').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            $('#jenis_kelamin').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            $('#jenis_identitas').select2({
                theme: "bootstrap-5",
                width: 'resolve'
            })

            //no identitas
            no_identitas.addEventListener('keyup', function(e){
                no_identitas.value = format_no_identitas(this.value, '');
            });

            no_telp.addEventListener('keyup', function(e){
                no_telp.value = format_no_telp(this.value, '');
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

            function format_no_telp(angka, prefix){
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
                                <textarea class="form-control border-dark" name="kronologis[]" placeholder="" id="kronologis" value="{{ old('kronologis') ? old('kronologis') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 160px" required></textarea>
                                <label for="kronologis" class="form-label">Fakta-fakta</label>
                            </div>`
                $('#kronologi_form').append(krono)
            });

            $('#add_catatan').on('click', function() {
                let krono = ''
                if ($('#tipe_data').val() == 2) {
                    krono += `<div class="form-floating mt-3">
                                <textarea class="form-control border-dark" name="catatan[]" placeholder="CATATAN" id="catatan" value="{{ old('catatan') ? old('catatan') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 160px" required></textarea>
                                <label for="catatan" class="form-label">Catatan</label>
                            </div>`
                } else if ($('#tipe_data').val() == 3) {
                    krono += `<div class="form-floating mt-3">
                                <textarea class="form-control border-dark" name="catatan[]" placeholder="CATATAN" id="catatan" value="{{ old('catatan') ? old('catatan') : '' }}" onkeyup="this.value = this.value.replace(/[&*<>]/g, '')" style="height: 160px" required></textarea>
                                <label for="catatan" class="form-label">Pendapat Pelapor</label>
                            </div>`
                }
                
                $('#catatan_form').append(krono)
            });

            $('#tipe_data').on('change', function() {
                
                if (this.value == 1) {
                    $('#no_nota_dinas').removeAttr('disabled')
                    $('#no_nota_dinas').prop('required',true)
                    $('#den_bag').prop('hidden', true)
                    $('#catatan_form').prop('hidden',true)
                    $('#btn_add_kronologi').prop('hidden',true)
                    $('#btn_add_catatan').prop('hidden',true)
                    $('#catatan').removeAttr('required')
                    $('#title_form').html('FORM INPUT ADUAN MASYARAKAT')
                } else if (this.value == 2) {
                    $('#no_nota_dinas').prop('disabled', true)
                    $('#form_den_bag').removeAttr('hidden')
                    $('#catatan_form').removeAttr('hidden')
                    $('#btn_add_kronologi').removeAttr('hidden')
                    $('#btn_add_catatan').removeAttr('hidden')
                    $('#title_form').html('FORM INPUT INFORMASI KHUSUS')
                    $('#label_kronologi').html('Fakta-fakta')
                    
                } else {
                    $('#no_nota_dinas').prop('disabled', true)
                    $('#no_nota_dinas').prop('required', true)
                    $('#form_den_bag').removeAttr('hidden')
                    $('#catatan_form').removeAttr('hidden')
                    $('#btn_add_kronologi').removeAttr('hidden')
                    $('#btn_add_catatan').removeAttr('hidden')
                    $('#title_form').html('FORM INPUT LAMPORAN INFORMASI')
                    $('#label_kronologi').html('Fakta-fakta')
                    $('#label_catatan').html('PENDAPAT PELAPOR')
                    $('#add_catatan').html('TAMBAH PENDAPAT PELAPOR')
                    
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
                            html = `<label for="unit_den_bag" class="form-label">UNIT</label><select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" disabled ><option value="" selected disabled>UNIT BELUM TERSEDIA</option></select>`
                        } else {
                            unit.forEach(element => {
                                let opt = `<option value="`+element.id+`">`+element.unit+`</option>`
                                option += opt
                            });
                            html = `<label for="unit_den_bag" class="form-label">UNIT</label><select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" required><option value="" selected disabled>PILIH UNIT</option>`+option+`</select>`
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

            // Example starter JavaScript for disabling form submissions if there are invalid fields
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            console.log(forms)

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    var errorElements = document.querySelectorAll("input.form-control:invalid");
                    errorElements.forEach(function(element) {
                        element.parentNode.childNodes.forEach(function(node) {
                            if (node.className == 'valid-feedback') {
                                node.className = 'invalid-feedback';
                            }
                        });
                    });
                    $('html, body').animate({
                        scrollTop: $(errorElements[0]).offset().top
                    }, 100);

                    form.classList.add('was-validated')
                }, false)
            })
        });
    </script>
@endsection
