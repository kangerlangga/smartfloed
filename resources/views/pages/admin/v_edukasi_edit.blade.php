@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
<div id="preloader"></div>
<style>
    #preloader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    overflow: hidden;
    background: #fff;
    }
    #preloader:before {
    content: "";
    position: fixed;
    top: calc(50% - 30px);
    left: calc(50% - 30px);
    border: 6px solid #FF8E00;
    border-top-color: #e7e4fe;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: animate-preloader 1s linear infinite;
    }
    @keyframes animate-preloader {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    }
    .form-group {
        margin-top: 17px;
    }
    .form-group input, select{
        margin-top: 3px;
    }
    .btn {
        width: 100px;
        margin-right: 5px;
    }
</style>
<form method="POST" action="{{ route('edukasi.update', $EditEdukasi->id_edukasi) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="Foto">Gambar Pendukung (PNG, JPG, JPEG) <b>Maksimal 3 MB</b> Ukuran Standar 1080px x 1080px</label>
                <input class="form-control-file @error('Foto') is-invalid @enderror" name="Foto" id="Foto" type="file" accept=".png, .jpg, .jpeg" @error('Foto') aria-describedby="FotoFeedback" @enderror>
                @error('Foto')
                <div id="FotoFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label for="Judul">Judul Artikel Edukasi</label>
                <input class="form-control @error('Judul') is-invalid @enderror" name="Judul" value="{{ old('Judul', $EditEdukasi->judul_edukasi) }}" id="Judul" @error('Judul') aria-describedby="JudulFeedback" @enderror required>
                @error('Judul')
                <div id="JudulFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label for="Isi">Isi Artikel Edukasi</label>
                <textarea class="form-control @error('Isi') is-invalid @enderror" id="Isi" name="Isi" @error('Isi') aria-describedby="IsiFeedback" @enderror>{{ old('Isi', $EditEdukasi->isi_edukasi) }}</textarea>
                @error('Isi')
                <div id="IsiFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Visibilitas">Visibilitas Artikel Edukasi</label>
                <br>
                <select name='visibilitas' id='Visibilitas' class="form-control">
                    <option name='visibilitas' value='Tampilkan' {{ $EditEdukasi->visib_edukasi == 'Tampilkan' ? 'selected' : '' }}>Tampilkan</option>
                    <option name='visibilitas' value='Sembunyikan' {{ $EditEdukasi->visib_edukasi == 'Sembunyikan' ? 'selected' : '' }}>Sembunyikan</option>
                </select>
            </div>
        </div>

    </div>
    <br>
    <button type="submit" class="btn btn-primary">SIMPAN</button>
    <a href="{{ route('edukasi.data') }}" class="btn btn-success tbl-kembali">KEMBALI</a>
</form>
<hr>
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font,
        Alignment,
        Autoformat,
        BlockQuote,
        CKFinder,
        CKFinderUploadAdapter,
        CloudServices,
        EasyImage,
        Heading,
        Image,
        ImageCaption,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
        Indent,
        Link,
        List,
        MediaEmbed,
        PasteFromOffice,
        Table,
        TableToolbar,
        TextTransformation
    } from 'ckeditor5';

    ClassicEditor
        .create( document.querySelector( '#Isi' ), {
            plugins: [
                Essentials, Paragraph, Bold, Italic, Font, Alignment, Autoformat, BlockQuote, CKFinder,
                CKFinderUploadAdapter, CloudServices, EasyImage, Heading, Image, ImageCaption, ImageStyle,
                ImageToolbar, ImageUpload, Indent, Link, List, MediaEmbed, PasteFromOffice, Table, TableToolbar,
                TextTransformation
            ],
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'alignment', 'indent', 'outdent', '|',
                'imageUpload', 'insertTable', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells'
                ]
            }
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
<!-- A friendly reminder to run on a server, remove this during the integration. -->
<script>
    window.onload = function() {
        if ( window.location.protocol === "file:" ) {
            alert( "This sample requires an HTTP server. Please serve this file with a web server." );
        }
    };
    document.getElementById('myForm').addEventListener('submit', function(event) {
        var editorData = window.editor.getData();
        if (!editorData.trim()) {
            Swal.fire({
            icon: "error",
            title: "Isi Artikel Edukasi Tidak Boleh Kosong!",
            showConfirmButton: false,
            timer: 3000
            });
            window.editor.editing.view.focus();
            event.preventDefault();
        } else {
            document.querySelector('#Isi').value = editorData;
        }
    });
</script>
<script type="text/javascript">

    $(document).on('click','.tbl-kembali',function(e) {

    //Hentikan aksi default
    e.preventDefault();
    const href1 = $(this).attr('href');

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Perubahan Tidak Akan Disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#fd7e14',
            confirmButtonText: 'KEMBALI',
            cancelButtonText: 'BATAL'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href1;
            }
        })
    })
</script>
@endsection
