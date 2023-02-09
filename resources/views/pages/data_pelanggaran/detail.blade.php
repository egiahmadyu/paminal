@extends('partials.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data No Nota Dinas {{ $kasus->no_nota_dinas }}</h4>

                </div><!-- end card header -->

                <div class="card-body" style="min-height:300px">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @foreach ($process as $proses)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $proses->id == $kasus->status_id ? 'active' : '' }}"
                                    id="{{ $proses->name }}-id" data-bs-toggle="pill" data-bs-target="#{{ $proses->name }}"
                                    type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">{{ $proses->name }}</button>
                            </li>
                        @endforeach

                    </ul>

                    <div class="tab-content px-3" id="pills-tabContent">
                        <div class="tab-pane fade {{ 1 == $kasus->status_id ? 'show active' : '' }}" id="Diterima"
                            role="tabpanel" aria-labelledby="pills-home-tab">Diterima</div>
                        <div class="tab-pane fade {{ 4 == $kasus->status_id ? 'show active' : '' }}" id="Pulbaket"
                            role="tabpanel" aria-labelledby="pills-profile-tab"> Pulbaket
                        </div>
                        <div class="tab-pane fade {{ 2 == $kasus->id ? 'show active' : '' }}" id="Disposisi" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Disposisi</label>
                                    <select class="form-select" aria-label="Default select example" name="disposisi-tujuan"
                                        {{ 2 != $kasus->status_id ? 'disabled' : '' }} onchange="getPolda()"
                                        id="disposisi-tujuan">
                                        <option value="Pulbaket">Pulbaket</option>
                                        <option value="Limpah">Limpah</option>
                                    </select>
                                </div>
                                <div id="limpah-polda">

                                </div>
                                <button type="submit" class="btn btn-primary"
                                    {{ 2 != $kasus->status_id ? 'disabled' : '' }}>Submit</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function getPolda() {
            let disposisi = $('#disposisi-tujuan').val()
            if (disposisi == 'Limpah') {
                // Panggil Form Polda
            }
        }
    </script>
@endsection
