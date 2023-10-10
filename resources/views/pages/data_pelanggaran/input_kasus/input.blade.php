@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        select:hover, #datepicker:hover, #datepicker_tgl_kejadian:hover {
            cursor: pointer;
        }
    </style>
@endprepend

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex justify-content-end">
            <li class="breadcrumb-item active"><a href="{{route('kasus.input')}}">Input Data</a></li>
        </ol>
    </nav>
    <div class="row form-control">
        <div class="form-control text-center border-0">
            <h3>Form Input Data</h3>
        </div>
        <form action="/input-data-kasus/store" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select border-dark" aria-label="Default select example" name="tipe_data" id="tipe_data" required>
                            <option value="">-- Pilih Tipe Aduan --</option>
                            <option value="1">Aduan Masyarakat</option>
                            @can('infosus-li')
                                <option value="2">Info Khusus</option>
                                <option value="3">Laporan Informasi</option>
                            @endcan
                            
                        </select>
                        <label for="tipe_data" class="form-label">Tipe Aduan</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas" placeholder="No. Nota Dinas" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" disabled required>
                        <label for="no_nota_dinas">No. Nota Dinas</label>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-0">
                    <center>
                        <div class="form-label">
                            <label for="check-box">Tipe Pelanggaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="disiplin" name="jenis_wp" value="1" onchange='disiplinChange(this);'>
                            <label class="form-check-label " for="disiplin">Disiplin</label>
                          </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input border-dark" type="checkbox" id="kode_etik" name="jenis_wp" value="2" onchange='kodeEtikChange(this);'>
                            <label class="form-check-label" for="kode_etik">Kode Etik</label>
                        </div>
                    </center>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select border-dark" aria-label="Default select example" name="wujud_perbuatan" id="wujud_perbuatan" disabled required>
                            <option value="">-- Pilih Wujud Perbuatan --</option>
                        </select>
                        <label for="wujud_perbuatan" class="form-label">Wujud Perbuatan</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" required>
                        <label for="tanggal_nota_dinas">Tanggal Nota Dinas</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control border-dark" name="perihal_nota_dinas" id="perihal_nota_dinas" placeholder="Perihal Nota Dinas" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" required>
                        <label for="perihal_nota_dinas">Perihal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating" id="den_bag" hidden>
                        <select class="form-select border-dark" aria-label="Default select example" name="den_bag">
                            <option value="">-- Pilih Bag / Detasemen --</option>
                            @foreach ($bag_den as $bd)
                                <option value="{{ $bd->id }}">{{ $bd->name }}</option>
                            @endforeach
                        </select>
                        <label for="den_bag" class="form-label">Bag / Detasemen</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating" id="unit_den_bag" hidden>
                        {{-- <select class="form-select border-dark" aria-label="Default select example" name="unit_den_bag" required>
                        </select>
                        <label for="unit_den_bag" class="form-label">Unit</label> --}}
                    </div>
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="pelapor" id="pelapor" placeholder="Nama Pelapor" value="{{ isset($kasus) ? $kasus->pelapor : '' }}" required>
                                <label for="pelapor">Nama Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="number" class="form-control border-dark" name="umur" id="umur" placeholder="Umur Pelapor" value="{{ isset($kasus) ? $kasus->umur : '' }}" required>
                                <label for="umur">Umur</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @if (isset($jenis_kelamin))
                                        @foreach ($jenis_kelamin as $key => $jk)
                                            <option value="{{ $jk->id }}" {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : '') : '' }}>{{ $jk->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="pekerjaan" class="form-control border-dark" placeholder="Pekerjaan Pelapor" value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}" required>
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            </div>
                           
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="agama" id="agama" required>
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach ($agama as $key => $ag)
                                        <option value="{{ $ag->id }}">{{ $ag->name }}</option>
                                    @endforeach
                                </select>
                                <label for="agama" class="form-label">Agama</label>
                            </div>
                            
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="no_identitas" id="no_identitas" placeholder="1234-5678-9012-1234" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_identitas : '' }}" required>
                                <label for="no_identitas" class="form-label">No Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas"id="jenis-identitas" required>
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    @if (isset($jenis_identitas))
                                        @foreach ($jenis_identitas as $key => $ji)
                                            <option value="{{ $ji->id }}" {{ isset($kasus) ? ($kasus->jenis_identitas == $ji->id ? 'selected' : '') : '' }}>{{ $ji->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" name="no_telp" id="no_telp" placeholder="No. Telp Pelapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_telp : '' }}" required>
                                <label for="no_telp" class="form-label">No. Telepon Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="alamat" placeholder="Alamat" id="floatingTextarea" value="{{ isset($kasus) ? $kasus->alamat : '' }}" style="height: 160px" required></textarea>
                                <label for="floatingTextarea" class="form-label">Alamat</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->nrp : '' }}" required>
                                <label for="nrp">NRP Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="terlapor" id="terlapor" placeholder="Nama Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->terlapor : '' }}" required>
                                <label for="terlapor">Nama Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="pangkat" id="pangkat" required>
                                    <option value="">-- Pilih Pangkat --</option>
                                    @if (isset($pangkat))
                                        @foreach ($pangkat as $key => $p)
                                            <option value="{{ $p->id }}">
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
                                <input type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->jabatan : '' }}" required>
                                <label for="jabatan">Jabatan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="kesatuan" id="kesatuan" placeholder="Kesatuan Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" required>
                                <label for="kesatuan">Kesatuan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <div class="form-floating">
                                    <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="wilayah_hukum" id="wilayah_hukum" required>
                                        <option value="">-- Mabes/Polda --</option>
                                        @if (isset($wilayah_hukum))
                                            @foreach ($wilayah_hukum as $key => $wh)
                                                <option value="{{ $wh->id }}">
                                                    {{ $wh->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="pangkat" class="form-label">Mabes/Polda</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="tempat_kejadian" id="tempat_kejadian" placeholder="Tempat Kejadian" value="{{ isset($kasus) ? $kasus->tempat_kejadian : '' }}" required>
                                <label for="tempat_kejadian">Tempat Kejadian</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}" required>
                                <label for="tempat_kejadian">Tanggal Kejadian</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" name="nama_korban" id="nama_korban" placeholder="Nama korban" value="{{ isset($kasus) ? $kasus->nama_korban : '' }}" required>
                                <label for="nama_korban">Nama Korban</label>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="kronologis" placeholder="Kronologis" id="kronologis" value="{{ isset($kasus) ? $kasus->kronologis : '' }}" style="height: 160px" required></textarea>
                                <label for="kronologis" class="form-label">Kronologis</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <button class="btn btn-success form-control" type="submit" value="input_kasus" name="type_submit">
                        Submit Data
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

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
                console.log('test');
                document.getElementById("wujud_perbuatan").removeAttribute("disabled");
                document.getElementById("kode_etik").setAttribute("disabled", "disabled");
                getValDisiplin()
            } else if ($('#kode_etik').is('checked')) {
                document.getElementById("wujud_perbuatan").removeAttribute("disabled");
                document.getElementById("disiplin").setAttribute("disabled", "disabled");
                getValKodeEtik()
            }

            $('#tipe_data').on('change', function() {
                console.log(this.value)
                if (this.value == 1) {
                    $('#no_nota_dinas').removeAttr('disabled')
                    $('#den_bag').prop('hidden', true)
                } else {
                    $('#no_nota_dinas').prop('disabled', true)
                    $('#no_nota_dinas').prop('required', true)
                    $('#den_bag').removeAttr('hidden')
                    
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
                        console.log(unit.length)
                        if (unit.length == 0) {
                            html = `<select class="form-select border-dark" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" disabled ><option value="">-- Unit Belum Tersedia --</option></select><label for="unit_den_bag" class="form-label">Unit</label>`
                        } else {
                            unit.forEach(element => {
                                let opt = `<option value="`+element.id+`">`+element.unit+`</option>`
                                option += opt
                            });
                            console.log(option)
                            html = `<select class="form-select border-dark" aria-label="Default select example" name="unit_den_bag" id="unit_den_bag" required><option value="">-- Pilih Unit --</option>`+option+`</select><label for="unit_den_bag" class="form-label">Unit</label>`
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

            let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
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
            $('#wujud_perbuatan').html(html_wp);
        }

        function getValKodeEtik() {
            console.log('test');
            let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
            let list_ketke = new Array();
            list_ketke = `{{ $kode_etik }}`;
            list_ketke = list_ketke.split('|');

            let list_id_ke = new Array();
            list_id_ke = `{{ $id_kode_etik }}`;
            list_id_ke = list_id_ke.split('|');

            let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
            let is_selected = '';
            for (let index = 0; index < list_ketke.length; index++) {
                const el_ketke = list_ketke[index];
                const el_id_ke = list_id_ke[index];
                if (kasus_wp != '' && kasus_wp == el_id_ke) {
                    is_selected = 'selected';
                }
                html_wp += `<option value="`+el_id_ke+`" `+is_selected+`>`+el_ketke+`</option>`;
                // console.log(html);
            }
            $('#wujud_perbuatan').html(html_wp);
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
    </script>
@endsection
