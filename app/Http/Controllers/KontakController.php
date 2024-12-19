<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kontakData = Kontak::latest()->limit(1)->get();

        $kontakData->map(function ($item) {
            $item->update_tgl = $this->formatTimestamp($item->updated_at);
            return $item;
        });

        $data = [
            'judul' => 'Detail Kontak',
            'jK' => Kontak::count(),
            'Kontak' => $kontakData,
        ];
        return view('pages.admin.v_kontak', $data);
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
        $kontak = Kontak::find($id);
        if ($kontak) {
            $data = [
                'judul' => 'Edit Informasi Kontak',
                'EditKontak' => Kontak::findOrFail($id),
            ];
            return view('pages.admin.v_kontak_edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $id = $request->input('id');
        $kontak = Kontak::find($id);
        if ($kontak) {
            // validate form
            $request->validate([
                'Email'        => 'required|email|max:255',
                'Alamat'       => 'required|max:255',
                'Telp'         => 'required|numeric|max_digits:13',
            ]);

            //get by ID
            $kontak = Kontak::findOrFail($id);

            //update
            $kontak->update([
                'email_kontak'  => $request->Email,
                'telp_kontak'   => $request->Telp,
                'wa_kontak'     => $request->wa,
                'alamat_kontak' => $request->Alamat,
                'visib_kontak'  => $request->visibilitas,
                'modified_by'   => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('kontak.data')->with(['success' => 'Kontak Berhasil Diperbarui!']);
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
