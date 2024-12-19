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
<form method="POST" action="{{ route('akun.update', $EditAkun->id_akun) }}" enctype="multipart/form-data">
    @csrf
<div class="row">

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Nama">Nama Lengkap</label>
            <input class="form-control @error('Nama') is-invalid @enderror" type="text" name="Nama" value="{{ $EditAkun->nama }}" id="Nama" @error('Nama') aria-describedby="NamaFeedback" @enderror required>
            @error('Nama')
            <div id="NamaFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Alamat">Alamat</label>
            <input class="form-control @error('Alamat') is-invalid @enderror" name="Alamat" value="{{ $EditAkun->alamat }}" id="Alamat" @error('Alamat') aria-describedby="AlamatFeedback" @enderror required>
            @error('Alamat')
            <div id="AlamatFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Jabatan">Jabatan</label>
            <input class="form-control @error('Jabatan') is-invalid @enderror" type="text" name="Jabatan" value="{{ $EditAkun->jabatan }}" id="Jabatan"  @error('Jabatan') aria-describedby="JabatanFeedback" @enderror required>
            @error('Jabatan')
            <div id="JabatanFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Email-Pengguna">Email</label>
            <input class="form-control" name="email" value="{{ $EditAkun->email }}" id="Email-Pengguna" type="email" readonly style="cursor: not-allowed">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Telp">Nomor Telepon</label>
            <input class="form-control @error('Telp') is-invalid @enderror" type="tel" name="Telp" value="{{ $EditAkun->telp }}" id="Telp" @error('Telp') aria-describedby="TelpFeedback" @enderror required>
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
                <option name='Level' value='Admin' {{ $EditAkun->level == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option name='Level' value='Super Admin' {{ $EditAkun->level == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
	        </select>
        </div>
    </div>

</div>
<br>
<button type="submit" class="btn btn-primary">SIMPAN</button>
<a href="{{  route('akun.data') }}" class="btn btn-success tbl-kembali">KEMBALI</a>
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
