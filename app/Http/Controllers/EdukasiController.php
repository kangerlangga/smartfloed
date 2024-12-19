<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'judul' => 'Artikel Edukasi Bencana',
            'DataEdukasi' => Edukasi::latest()->get(),
        ];
        return view('pages.admin.v_edukasi', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'judul' => 'Tambah Artikel Edukasi Bencana',
        ];
        return view('pages.admin.v_edukasi_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validate form
        $request->validate([
            'Foto'  => 'required|image|mimes:jpeg,jpg,png|max:3072',
            'Judul' => 'required|max:255',
            'Isi'   => 'required',
        ]);

        //upload image
        $foto = $request->file('Foto');
        $fotoName = time().Str::random(17).'.'.$foto->getClientOriginalExtension();
        $foto->move('assets/foto/edukasi/', $fotoName);

        //create
        Edukasi::create([
            'id_edukasi'        => 'Edukasi'.Str::random(33),
            'id_detail'         => Str::random(17),
            'judul_edukasi'     => $request->Judul,
            'isi_edukasi'       => $request->Isi,
            'foto_edukasi'      => $fotoName,
            'penulis_edukasi'   => Auth::user()->nama,
            'visib_edukasi'     => $request->visibilitas,
            'created_by'        => Auth::user()->email,
            'modified_by'       => Auth::user()->email,
        ]);

        //redirect to index
        return redirect()->route('edukasi.tambah')->with(['success' => 'Artikel Edukasi Berhasil Ditambahkan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $edukasiData = Edukasi::where('id_detail', $id)->where('visib_edukasi', 'Tampilkan')->firstOrFail();

        $edukasiData->format_tgl = $this->formatTimestamp($edukasiData->created_at);

        $data = [
            'judul' => $edukasiData->judul_edukasi,
            'DetailEdukasi' => $edukasiData,
        ];
        return view('pages.public.edukasi_detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'judul' => 'Edit Artikel Edukasi Bencana',
            'EditEdukasi' => Edukasi::findOrFail($id),
        ];
        return view('pages.admin.v_edukasi_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate form
        $request->validate([
            'Foto'  => 'image|mimes:jpeg,jpg,png|max:3072',
            'Judul' => 'required|max:255',
            'Isi'   => 'required',
        ]);

        //get by ID
        $edukasi = Edukasi::findOrFail($id);

        //cek gambar di upload
        if ($request->hasFile('Foto')) {
            $edukasi_path = 'assets/foto/edukasi/' . $edukasi->foto_edukasi;
            if (file_exists($edukasi_path)) {
                unlink($edukasi_path);
            }
            //upload image
            $foto = $request->file('Foto');
            $fotoName = time().Str::random(17).'.'.$foto->getClientOriginalExtension();
            $foto->move('assets/foto/edukasi/', $fotoName);

            //update
            $edukasi->update([
                'judul_edukasi'     => $request->Judul,
                'isi_edukasi'       => $request->Isi,
                'foto_edukasi'      => $fotoName,
                'visib_edukasi'     => $request->visibilitas,
                'modified_by'       => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('edukasi.data')->with(['success' => 'Artikel Edukasi Berhasil Diperbarui!']);
        }else{
            //update
            $edukasi->update([
                'judul_edukasi'     => $request->Judul,
                'isi_edukasi'       => $request->Isi,
                'visib_edukasi'     => $request->visibilitas,
                'modified_by'       => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('edukasi.data')->with(['success' => 'Artikel Edukasi Berhasil Diperbarui!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get by ID
        $edukasi = Edukasi::findOrFail($id);

        //delete image
        $edukasi_path = 'assets/foto/edukasi/' . $edukasi->foto_edukasi;
        if (file_exists($edukasi_path)) {
            unlink($edukasi_path);
        }

        //delete
        $edukasi->delete();

        //redirect to index
        return redirect()->route('edukasi.data')->with(['success' => 'Artikel Edukasi Berhasil Dihapus!']);
    }

    private function formatTimestamp($timestamp)
    {
        $date = Carbon::parse($timestamp);

        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        $dayName = $days[$date->format('l')];
        $monthName = $months[$date->format('F')];

        return $dayName . ', ' . $date->format('d') . ' ' . $monthName . ' ' . $date->format('Y') . ' | ' . $date->format('H:i') . ' WIB';
    }
}
