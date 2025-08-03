<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $lokasiData = Lokasi::latest()->limit(1)->get();

        $lokasiData->map(function ($item) {
            $item->update_tgl = $this->formatTimestamp($item->updated_at);
            return $item;
        });

        $data = [
            'judul' => 'Detail Lokasi Penempatan Alat',
            'jL' => Lokasi::count(),
            'Lokasi' => $lokasiData,
        ];
        return view('pages.admin.v_lokasi', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $lokasi = Lokasi::find($id);
        if ($lokasi) {
            $data = [
                'judul' => 'Edit Detail Lokasi',
                'EditLokasi' => Lokasi::findOrFail($id),
            ];
            return view('pages.admin.v_lokasi_edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $lokasi = Lokasi::find($id);
        if ($lokasi) {
            // validate form
            $request->validate([
                'Foto'          => 'image|mimes:jpeg,jpg,png|max:3072',
                'Nama'          => 'required|max:255',
                'Ketinggian'    => 'required|numeric',
                'Status'        => 'required|max:255',
                'Latlng'        => 'required|max:255',
            ]);

            //get by ID
            $lokasi = Lokasi::findOrFail($id);

            //cek gambar di upload
            if ($request->hasFile('Foto')) {
                $lokasi_path = 'assets/foto/lokasi/' . $lokasi->foto_lokasi;
                if (file_exists($lokasi_path)) {
                    unlink($lokasi_path);
                }
                //upload image
                $foto = $request->file('Foto');
                $fotoName = time().Str::random(17).'.'.$foto->getClientOriginalExtension();
                $foto->move('assets/foto/lokasi/', $fotoName);

                //update
                $lokasi->update([
                    'foto_lokasi'       => $fotoName,
                    'nama_lokasi'       => $request->Nama,
                    'ketinggian_lokasi' => $request->Ketinggian,
                    'sensor_lokasi'     => $request->Sensor,
                    'status_lokasi'     => $request->Status,
                    'visib_lokasi'      => $request->visibilitas,
                    'latlng_lokasi'     => $request->Latlng,
                    'modified_by'       => Auth::user()->email,
                ]);

                //redirect to index
                return redirect()->route('lokasi.data')->with(['success' => 'Detail Lokasi Berhasil Diperbarui!']);
            }else{
                //update
                $lokasi->update([
                    'nama_lokasi'       => $request->Nama,
                    'ketinggian_lokasi' => $request->Ketinggian,
                    'sensor_lokasi'     => $request->Sensor,
                    'status_lokasi'     => $request->Status,
                    'visib_lokasi'      => $request->visibilitas,
                    'latlng_lokasi'     => $request->Latlng,
                    'modified_by'       => Auth::user()->email,
                ]);

                //redirect to index
                return redirect()->route('lokasi.data')->with(['success' => 'Detail Lokasi Berhasil Diperbarui!']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
