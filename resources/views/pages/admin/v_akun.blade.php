@extends('layouts.admin.admin')

@section('title')
<title>{{ $judul }} | Smart Floed</title>
@endsection

@section('pageHeading')
<h1 class="h3 mb-2 text-gray-800"><b>{{ $judul }}</b></h1>
@endsection

@section('page')
<div class="row">
    <div class="col-12 table-responsive">
        <a href="{{ route('akun.tambah') }}" class="btn btn-success mb-3 fw-bold">Buat Akun Baru</a>
        <table class="table table-bordered pt-3" id="tabel-akun">
        <colgroup>
            <col span="1" style="width: 5%;">
            <col span="1" style="width: 20%;">
            <col span="1" style="width: 40%;">
            <col span="1" style="width: 15%;">
            <col span="1" style="width: 20%;">
        </colgroup>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Admin</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($DataAkun as $a)
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->email }}</td>
                        <td>{{ $a->telp }}</td>
                        <td>
                            <a href="{{ route('akun.resetpass', $a->id_akun) }}" class="btn btn-info tbl-resetpass"><i class="fa-solid fa-rotate-left"></i></a>
                            <a href="{{ route('akun.edit', $a->id_akun) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{ route('akun.hapus', $a->id_akun) }}" class="btn btn-danger tbl-hapus"><i class="fa-solid fa-trash"></i></a>

                            @if (Auth::user()->level == 'Super Admin')
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#{{ $a->id_akun }}">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="{{ $a->id_akun }}" tabindex="-1" role="dialog" aria-labelledby="{{ $a->id_akun }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{ $a->id_akun }}Label"><b>Riwayat Aktivitas</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Created : <br>{{ $a->created_by }} <b>({{ $a->created_at }})</b></p>
                                        <p>Last Modified : <br>{{ $a->modified_by }} <b>({{ $a->updated_at }})</b></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    let table = new DataTable('#tabel-akun');

    $(document).on('click','.tbl-hapus',function(e) {

        //Hentikan aksi default
        e.preventDefault();
        const href1 = $(this).attr('href');

        Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Data Ini Akan Dihapus Secara Permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#fd7e14',
        confirmButtonText: 'HAPUS DATA',
        cancelButtonText: 'BATAL'
        }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href1;
        }
        })
    })

        $(document).on('click','.tbl-resetpass',function(e) {

        //Hentikan aksi default
        e.preventDefault();
        const href1 = $(this).attr('href');

        Swal.fire({
        title: 'Password Admin Akan Di Reset!',
        text: "Default = Banjir#SMARTFLOED.Bisa272",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#fd7e14',
        confirmButtonText: 'RESET PASSWORD',
        cancelButtonText: 'BATAL'
        }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href1;
        }
        })
    })

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
