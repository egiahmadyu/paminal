<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(1)"><i class="far fa-arrow-left"></i> SEBELUMNYA</button>
            </div>

            {{-- <div>
                @if ($kasus->status_id > 2)
                    <button type="button" class="btn btn-info" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif
            </div> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="75" data-number-of-steps="2" style="width: 75%;">
                    </div>
                </div>
                <a href="javascript::void(0)" onclick="getViewProcess(1)">
                    <div class="f1-step" style="width: 50%;">
                        <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                        <p>DITERIMA</p>
                    </div>
                </a>

                <div class="f1-step active" style="width: 50%;">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>LIMPAH</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <h4>Limpah Ke Polda</h4>
        <form action="/surat-limpah-polda/{{ $kasus->id }}" method="post">
            @csrf
            <div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Polda / Sederajat</label>
                        <input type="text" class="form-control border-dark" id="polda_limpah" readonly
                            value="{{ $limpahPolda->polda->name }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Limpah</label>
                        <input type="text" class="form-control border-dark" readonly value="{{ $tgl_limpah }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Pelimpah</label>
                        <input type="text" class="form-control border-dark" readonly value="{{ $limpahPolda->user->name }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="title">
                            <h3>Isi Surat Limpah</h3>
                        </div>
                        <div class="container">
                            <textarea name="ticketDesc" id="myTextarea" cols="30" rows="10">{{ $limpahPolda->isi_surat }}</textarea>
                        </div>
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-primary">Generate Surat Limpah</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editControls a').click(function(e) {
            e.preventDefault();
            switch ($(this).data('role')) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'p':
                    document.execCommand('formatBlock', false, $(this).data('role'));
                    break;
                default:
                    document.execCommand($(this).data('role'), false, null);
                    break;
            }

            var textval = $("#editor").html();
            $("#editorCopy").val(textval);
        });

        $("#editor").keyup(function() {
            var value = $(this).html();
            $("#editorCopy").val(value);
        }).keyup();

        $('#checkIt').click(function(e) {
            e.preventDefault();
            alert($("#editorCopy").val());
        });
    });
</script>

<script src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#myTextarea',
        placaholder: 'test',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
        { title: 'My page 1', value: 'https://www.codexworld.com' },
        { title: 'My page 2', value: 'http://www.codexqa.com' }
        ],
        image_list: [
        { title: 'My page 1', value: 'https://www.codexworld.com' },
        { title: 'My page 2', value: 'http://www.codexqa.com' }
        ],
        image_class_list: [
        { title: 'None', value: '' },
        { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: (callback, value, meta) => {
        /* Provide file and text for the link dialog */
        if (meta.filetype === 'file') {
            callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
        }
    
        /* Provide image and alt text for the image dialog */
        if (meta.filetype === 'image') {
            callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
        }
    
        /* Provide alternative source and posted for the media dialog */
        if (meta.filetype === 'media') {
            callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
        }
        },
        templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
        { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 400,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>
