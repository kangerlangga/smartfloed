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
<form method="POST" action="{{ route('prof.update') }}" enctype="multipart/form-data">
    @csrf
<div class="row">

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Nama">Nama Lengkap</label>
            <input class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ Auth::user()->nama }}" id="Nama" @error('nama') aria-describedby="NamaFeedback" @enderror required>
            @error('nama')
            <div id="NamaFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Alamat">Alamat</label>
            <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ Auth::user()->alamat }}" id="Alamat" @error('alamat') aria-describedby="AlamatFeedback" @enderror required>
            @error('alamat')
            <div id="AlamatFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Jabatan">Jabatan</label>
            <input class="form-control @error('nama') is-invalid @enderror" name="jabatan" value="{{ Auth::user()->jabatan }}" id="Jabatan" @error('jabatan') aria-describedby="JabatanFeedback" @enderror required>
            @error('jabatan')
            <div id="JabatanFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Email-Pengguna">Email</label>
            <input class="form-control" name="email" value="{{ Auth::user()->email }}" id="Email-Pengguna" type="email" readonly style="cursor: not-allowed">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Telp-Pengguna">Telepon</label>
            <input class="form-control @error('nama') is-invalid @enderror" name="telp" value="{{ Auth::user()->telp }}" id="Telp-Pengguna" type="tel" @error('telp') aria-describedby="TelpFeedback" @enderror required>
            @error('telp')
            <div id="TelpFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Level">Level Admin</label>
            <input class="form-control" name="level" value="{{ Auth::user()->level }}" id="Level" readonly style="cursor: not-allowed">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="password">Masukkan Password Anda</label>
            <input class="form-control" name="password" id="password" type="password" required>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="tampilPass">
            <label class="form-check-label" for="tampilPass">
                Tampilkan password
            </label>
        </div>

    </div>

</div>
<br>
<button type="submit" class="btn btn-primary">SIMPAN</button>
<a href="{{ route('admin.dash') }}" class="btn btn-success tbl-kembali" style="width: auto;">KEMBALI KE DASHBOARD</a>
<a href="{{ route('prof.edit.pass') }}" class="btn btn-danger" style="width: auto;">GANTI PASSWORD</a>
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

    document.getElementById('tampilPass').onclick = function() {
        if ( this.checked ) {
        document.getElementById('password').type = "text";
        } else {
        document.getElementById('password').type = "password";
        }
    };

    @if(session('passerror'))
        Swal.fire({
        icon: 'error',
        title: "{{ session('passerror') }}",
        text: 'Tidak Dapat Memperbarui Informasi Akun',
        showConfirmButton: false,
        timer: 3000
        })
    @endif

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
            confirmButtonText: 'KEMBALI KE DASHBOARD',
            cancelButtonText: 'BATAL'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href1;
            }
        })
    })
</script>
@endsection
