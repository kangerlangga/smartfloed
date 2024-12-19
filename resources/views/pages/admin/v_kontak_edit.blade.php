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
<form method="POST" action="{{ route('kontak.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="{{ $EditKontak->id_kontak }}">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Email">Email</label>
                <input class="form-control @error('Email') is-invalid @enderror" name="Email" value="{{ old('Email', $EditKontak->email_kontak) }}" id="Email" type="Email" @error('Email') aria-describedby="EmailFeedback" @enderror required>
                @error('Email')
                <div id="EmailFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Telp">Telepon (Angka 0 Diawal Tidak Ditulis, Tanpa Spasi)</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="Telpon">+62</span>
                    </div>
                    <input class="form-control @error('Telp') is-invalid @enderror" type="tel" name="Telp" value="{{ old('Telp', $EditKontak->telp_kontak) }}" id="Telp" @error('Telp') aria-describedby="TelpFeedback" @enderror required>
                    @error('Telp')
                    <div id="TelpFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="WA">Whatsapp</label>
                <br>
                <select name='wa' id='WA' class="form-control">
                    <option name='wa' value='Tersedia' {{ $EditKontak->wa_kontak == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option name='wa' value='Tidak Tersedia' {{ $EditKontak->wa_kontak == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Alamat">Alamat Kantor Kepala Desa</label>
                <input class="form-control @error('Alamat') is-invalid @enderror" name="Alamat" value="{{ old('Alamat', $EditKontak->alamat_kontak) }}" id="Alamat" @error('Alamat') aria-describedby="AlamatFeedback" @enderror required>
                @error('Alamat')
                <div id="AlamatFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="Visibilitas">Visibilitas Kontak</label>
                <br>
                <select name='visibilitas' id='Visibilitas' class="form-control">
                    <option name='visibilitas' value='Tampilkan' {{ $EditKontak->visib_kontak == 'Tampilkan' ? 'selected' : '' }}>Tampilkan</option>
                    <option name='visibilitas' value='Sembunyikan' {{ $EditKontak->visib_kontak == 'Sembunyikan' ? 'selected' : '' }}>Sembunyikan</option>
                </select>
            </div>
        </div>

    </div>
    <br>
    <button type="submit" class="btn btn-primary">SIMPAN</button>
    <a href="{{ route('kontak.data') }}" class="btn btn-success tbl-kembali">KEMBALI</a>
</form>
<hr>
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
