@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        select:hover, #datepicker:hover {
            cursor: pointer;
        }
    </style>
@endprepend

@section('content')
    <div class="row form-control">
        <div class="text-center">
            <h3>Form Input Dumas</h3>
        </div>
        <form action="/input-data-kasus/store" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label for="no_nota_dinas" class="form-label">No. Nota Dinas</label>
                    <input type="text" name="no_nota_dinas" class="form-control border-dark" placeholder="No. Nota Dinas" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" >
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="perihal_nota_dinas" class="form-label">Perihal Nota Dinas</label>
                    <input type="text" name="perihal_nota_dinas" class="form-control border-dark" placeholder="Perihal Nota Dinas" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" >
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="wujud_perbuatan" class="form-label">Wujud Perbuatan</label>
                    <input type="text" name="wujud_perbuatan" class="form-control border-dark" placeholder="Wujud Perbuatan" value="{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}" >
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="tanggal_nota_dinas" class="form-label">Tanggal Nota Dinas</label>
                    <input type="text" name="tanggal_nota_dinas" class="form-control border-dark" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" >
                </div>
                <hr>
            </div>
            {{-- <input type="text" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->id : '' }}" hidden name="kasus_id"> --}}
            <div class="row">
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="pelapor" class="form-label">Pelapor</label>
                            <input type="text" name="pelapor" class="form-control border-dark" placeholder="Nama Pelapor" value="{{ isset($kasus) ? $kasus->pelapor : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="umur" class="form-label">Umur</label>
                            <input type="number" name="umur" class="form-control border-dark" placeholder="Umur Pelapor" value="{{ isset($kasus) ? $kasus->umur : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            {{-- <input type="text" name="jenis_kelamin" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->jenis_kelamin : '' }}" > --}}
                            <select class="form-select border-dark" aria-label="Default select example" name="jenis_kelamin"id="jenis-kelamin">
                                <option value="" selected>-- Jenis Kelamin --</option>
                                {{-- <option value="0">Laki-laki</option>
                                <option value="1">Perempuan</option> --}}
                                @if (isset($jenis_kelamin))
                                    @foreach ($jenis_kelamin as $key => $jk)
                                        <option value="{{ $jk->id }}" {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : '') : '' }}>{{ $jk->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control border-dark" placeholder="Pekerjaan Pelapor" value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            {{-- <input type="text" name="agama" class="form-control border-dark" placeholder="Agama Pelapor" value="{{ isset($kasus) ? $kasus->agama : '' }}" > --}}
                            <select class="form-select border-dark" aria-label="Default select example" name="agama" id="agama">
                                <option value="" selected>-- Agama --</option>
                                @foreach ($agama as $key => $ag)
                                    <option value="{{ $ag->id }}">{{ $ag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="no_identitas" class="form-label">No Identitas</label>
                            <input type="text" name="no_identitas" id="no_identitas" placeholder="1234-5678-9012-1234" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_identitas : '' }}" >
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            {{-- <input type="text" name="jenis_identitas" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->jenis_identitas : '' }}" > --}}
                            <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas"id="jenis-identitas">
                                <option value="" selected>-- Jenis Identitas --</option>
                                @if (isset($jenis_identitas))
                                    @foreach ($jenis_identitas as $key => $ji)
                                        <option value="{{ $ji->id }}" {{ isset($kasus) ? ($kasus->jenis_identitas == $ji->id ? 'selected' : '') : '' }}>{{ $ji->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" cols="30" rows="9" placeholder="Alamat" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->alamat : '' }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="terlapor" class="form-label">Terlapor</label>
                            <input type="text" name="terlapor" placeholder="Nama Terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->terlapor : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="pangkat" class="form-label">Pangkat</label>
                            <input type="text" name="pangkat" placeholder="Pangkat Terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->pangkat : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="nrp" class="form-label">NRP</label>
                            <input type="text" name="nrp" placeholder="NRP Terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->nrp : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" placeholder="Jabatan Terlapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->jabatan : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="kesatuan" class="form-label">Kesatuan</label>
                            <input type="text" name="kesatuan" class="form-control border-dark" placeholder="Kesatuan" value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="tempat_kejadian" class="form-label">Tempat Kejadian</label>
                            <input type="text" name="tempat_kejadian" class="form-control border-dark" placeholder="Tempat Kejadian" value="{{ isset($kasus) ? $kasus->tempat_kejadian : '' }}"
                                >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
                            <input type="text" id="datepicker" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}" >
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="nama_korban" class="form-label">Nama Korban</label>
                            <input type="text" name="nama_korban" class="form-control border-dark" placeholder="Nama Korban" value="{{ isset($kasus) ? $kasus->nama_korban : '' }}" >
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="kronologis" class="form-label">Kronologis</label>
                            <textarea name="kronologis" cols="30" rows="5" class="form-control border-dark" placeholder="Kronologi Kejadian" value="{{ isset($kasus) ? $kasus->kronologi : '' }}" ></textarea>
                        </div>
                        {{-- <div class="col-lg-12 mb-3">
                            <label for="download_berkas_disposisi" class="form-label">Download Berkas Disposisi</label>
                            <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                data-bs-target="#modal_disposisi" type="button">Download</button>
                            <input type="text" class="form-control border-dark" value="{{ $kasus->terlapor }}" >
                        </div> --}}
                        {{-- <div class="col-lg-12 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select border-dark" aria-label="Default select example" name="status" id="status" disabled>
                                <option value="1" selected>-- Status --</option>
                                <option value=""></option>
                            </select>
                        </div> --}}
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
        });

        $( function() {
            $( "#datepicker" ).datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
                language: 'id'
            });
        } );
    </script>
@endsection
