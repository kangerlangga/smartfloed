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
<form method="POST" action="{{ route('prof.update.pass') }}" enctype="multipart/form-data">
    @csrf
<div class="row">

    <div class="col-sm-12">
        <div class="form-group">
            <label for="Old-Pass">Password Lama</label>
            <input class="form-control" name="oldPass" id="Old-Pass" type="password" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="New-Pass">Password Baru</label>
            <input class="form-control" name="newPass" id="New-Pass" type="password" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="Confirm-Pass">Konfirmasi Password Baru</label>
            <input class="form-control @error('confirmPass') is-invalid @enderror" name="confirmPass" id="Confirm-Pass" type="password" @error('confirmPass') aria-describedby="KonfirmFeedback" @enderror required>
            @error('confirmPass')
            <div id="KonfirmFeedback" class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="lihat-password">
            <label class="form-check-label" for="lihat-password">Tampilkan Password</label>
        </div>
    </div>

</div>
<br>
<button type="submit" class="btn btn-danger" style="width: auto;">GANTI PASSWORD</button>
<a href="{{ route('prof.edit') }}" class="btn btn-success">KEMBALI</a>
</form>
<hr>
<form id="logout-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    //message with sweetalert
    @if(session('success'))
        Swal.fire({
        icon: 'success',
        title: "{{ session('success') }}",
        text: 'Anda Akan Logout Dalam Beberapa Detik!',
        showConfirmButton: false,
        timer: 5000
        })
        setTimeout(
        function(){
            document.getElementById('logout-admin').submit();
        },
        5000); // waktu tunggu atau delay
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    $(document).ready(function() {
        $('#lihat-password').click(function() {
            if ($(this).is(':checked')) {
                $('#Old-Pass').attr('type', 'text');
                $('#New-Pass').attr('type', 'text');
                $('#Confirm-Pass').attr('type', 'text');
            } else {
                $('#Old-Pass').attr('type', 'password');
                $('#New-Pass').attr('type', 'password');
                $('#Confirm-Pass').attr('type', 'password');
            }
        });
    })

</script>
@endsection
