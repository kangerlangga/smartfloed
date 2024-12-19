<?php

namespace App\Http\Controllers;

use App\Models\Tentang;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TentangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tentangData = Tentang::latest()->limit(1)->get();

        $tentangData->map(function ($item) {
            $item->update_tgl = $this->formatTimestamp($item->updated_at);
            return $item;
        });

        $data = [
            'judul' => 'Detail Informasi Desa Kedungbanteng',
            'jT' => Tentang::count(),
            'Tentang' => $tentangData,
        ];
        return view('pages.admin.v_tentang', $data);
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
    public function edit(Request $request): View
    {
        $id = $request->input('id');
        $tentang = Tentang::find($id);
        if ($tentang) {
            $data = [
                'judul' => 'Edit Informasi Desa Kedungbanteng',
                'EditTentang' => Tentang::findOrFail($id),
            ];
            return view('pages.admin.v_tentang_edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $id = $request->input('id');
        $tentang = Tentang::find($id);
        if ($tentang) {
            // validate form
            $request->validate([
                'Foto'          => 'image|mimes:jpeg,jpg,png|max:3072',
                'Detail'        => 'required',
            ]);

            //get by ID
            $tentang = Tentang::findOrFail($id);

            //cek gambar di upload
            if ($request->hasFile('Foto')) {
                $tentang_path = 'assets/foto/tentang/' . $tentang->foto_tentang;
                if (file_exists($tentang_path)) {
                    unlink($tentang_path);
                }
                //upload image
                $foto = $request->file('Foto');
                $fotoName = time().Str::random(17).'.'.$foto->getClientOriginalExtension();
                $foto->move('assets/foto/tentang/', $fotoName);

                //update
                $tentang->update([
                    'detail_tentang' => $request->Detail,
                    'foto_tentang'   => $fotoName,
                    'visib_tentang'  => $request->visibilitas,
                    'modified_by'   => Auth::user()->email,
                ]);

                //redirect to index
                return redirect()->route('tentang.data')->with(['success' => 'Informasi Berhasil Diperbarui!']);
            }else{
                //update
                $tentang->update([
                    'detail_tentang' => $request->Detail,
                    'visib_tentang'  => $request->visibilitas,
                    'modified_by'   => Auth::user()->email,
                ]);

                //redirect to index
                return redirect()->route('tentang.data')->with(['success' => 'Informasi Berhasil Diperbarui!']);
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
