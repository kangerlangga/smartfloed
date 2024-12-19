@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
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
<form method="POST" action="{{ route('akun.store') }}" enctype="multipart/form-data">
    @csrf
<div class="row">

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Nama">Nama Lengkap</label>
            <input class="form-control @error('Nama') is-invalid @enderror" type="text" name="Nama" value="{{ old('Nama') }}" id="Nama" @error('Nama') aria-describedby="NamaFeedback" @enderror required>
            @error('Nama')
            <div id="NamaFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Alamat">Alamat</label>
            <input class="form-control @error('Alamat') is-invalid @enderror" name="Alamat" value="{{ old('Alamat') }}" id="Alamat" @error('Alamat') aria-describedby="AlamatFeedback" @enderror required>
            @error('Alamat')
            <div id="AlamatFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Jabatan">Jabatan</label>
            <input class="form-control @error('Jabatan') is-invalid @enderror" type="text" name="Jabatan" value="{{ old('Jabatan') }}" id="Jabatan"  @error('Jabatan') aria-describedby="JabatanFeedback" @enderror required>
            @error('Jabatan')
            <div id="JabatanFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Email-Pengguna">Email</label>
            <input class="form-control @error('Email') is-invalid @enderror" name="Email" value="{{ old('Email') }}" id="Email-Pengguna" type="Email" @error('Email') aria-describedby="EmailFeedback" @enderror required>
            @error('Email')
            <div id="EmailFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Telp">Nomor Telepon</label>
            <input class="form-control @error('Telp') is-invalid @enderror" type="tel" name="Telp" value="{{ old('Telp') }}" id="Telp" @error('Telp') aria-describedby="TelpFeedback" @enderror required>
            @error('Telp')
            <div id="TelpFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Level">Level Admin</label>
            <br>
            <select name='Level' id='Level' class="form-control">
                <option name='Level' value='Admin'>Admin</option>
                <option name='Level' value='Super Admin'>Super Admin</option>
	        </select>
        </div>
    </div>

</div>
<br>
<button type="submit" class="btn btn-primary" style="width: auto;">BUAT AKUN</button>
<button type="reset" class="btn btn-success">RESET</button>
</form>
<hr>

<script>
    //message with sweetalert
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@endsection
