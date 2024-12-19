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
    <a href="{{ route('edukasi.tambah') }}" class="btn btn-success mb-3 fw-bold">Tambahkan Artikel Edukasi</a>
        <table class="table table-bordered pt-3" id="tabel-edukasi">
        <colgroup>
            <col span="1" style="width: 5%;">
            <col span="1" style="width: 20%;">
            <col span="1" style="width: 30%;">
            <col span="1" style="width: 13%;">
            <col span="1" style="width: 17%;">
        </colgroup>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Judul</th>
                    <th>Visibilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($DataEdukasi as $E)
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><center><img src="{{  url('') }}/assets/foto/edukasi/{{ $E->foto_edukasi }}" width="95%"></center></td>
                        <td>{{ $E->judul_edukasi }}</td>
                        <td>{{ $E->visib_edukasi }}</td>
                        <td>
                            <a href="{{ route('edukasi.edit', $E->id_edukasi) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{ route('edukasi.hapus', $E->id_edukasi) }}" class="btn btn-danger tbl-hapus"><i class="fa-solid fa-trash"></i></a>

                            @if (Auth::user()->level == 'Super Admin')
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#{{ $E->id_edukasi }}">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="{{ $E->id_edukasi }}" tabindex="-1" role="dialog" aria-labelledby="{{ $E->id_edukasi }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{ $E->id_edukasi }}Label"><b>Riwayat Aktivitas</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Created : <br>{{ $E->created_by }} <b>({{ $E->created_at }})</b></p>
                                        <p>Last Modified : <br>{{ $E->modified_by }} <b>({{ $E->updated_at }})</b></p>
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
    let table = new DataTable('#tabel-edukasi');

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
