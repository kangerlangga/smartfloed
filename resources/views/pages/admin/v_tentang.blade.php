@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
<div class="container">
    <?php if ($jT == 1) : ?>
    @foreach ($Tentang as $T)
    <p class="font-italic text-danger mt-3">Terakhir Diperbarui : <b>{{ $T->update_tgl }} </b>
        @if (Auth::user()->level == 'Super Admin')
        <b>({{ $T->modified_by }})</b>
        @endif
    </p>
    @if ($T->visib_tentang == 'Tampilkan')
        <p class="font-italic text-success"><i class="fas fa-fw fa-solid fa-eye"></i> Published</p>
    @elseif ($T->visib_tentang == 'Sembunyikan')
        <p class="font-italic text-warning"><i class="fas fa-fw fa-solid fa-eye-slash"></i> Unpublished</p>
    @endif
    <div class="text-center pt-2">
        <img src="{{  url('') }}/assets/foto/tentang/{{ $T->foto_tentang }}" class="img-thumbnail m-3" style="max-width: 50vw; border-radius: 25px;">
    </div>
    <div class="lead mt-2 mb-3" style="text-align: justify;">
        <?= $T['detail_tentang']; ?>
    </div>
    <form action="{{ route('tentang.edit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="hidden" name="id" value="{{ $T->id_tentang }}">
        <button type="submit" class="btn btn-warning">Perbarui Informasi Desa Kedungbanteng</button>
    </form>
    @endforeach
    <?php endif;?>
</div>

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
