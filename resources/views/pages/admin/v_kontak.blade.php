@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
<div class="container">
    <?php if ($jK == 1) : ?>
    @foreach ($Kontak as $K)
    <p class="font-italic text-danger mt-3">Terakhir Diperbarui : <b>{{ $K->update_tgl }} </b>
        @if (Auth::user()->level == 'Super Admin')
        <b>({{ $K->modified_by }})</b>
        @endif
    </p>
    @if ($K->visib_kontak == 'Tampilkan')
        <p class="font-italic text-success"><i class="fas fa-fw fa-solid fa-eye"></i> Published</p>
    @elseif ($K->visib_kontak == 'Sembunyikan')
        <p class="font-italic text-warning"><i class="fas fa-fw fa-solid fa-eye-slash"></i> Unpublished</p>
    @endif
    <div class="table-responsive">
        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <td class="text-uppercase font-weight-bold w-25">Email</td>
                    <td>:</td>
                    <td>{{ $K->email_kontak }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase font-weight-bold">Telepon</td>
                    <td>:</td>
                    <td>+62 {{ $K->telp_kontak }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase font-weight-bold">Whatsapp</td>
                    <td>:</td>
                    <td>{{ $K->wa_kontak }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase font-weight-bold">Kantor Kepala Desa</td>
                    <td>:</td>
                    <td>{{ $K->alamat_kontak }}</td>
                </tr>                                                                                                      </tbody>
        </table>
    </div>
    <form action="{{ route('kontak.edit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="hidden" name="id" value="{{ $K->id_kontak }}">
        <button type="submit" class="btn btn-warning">Perbarui Kontak</button>
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
