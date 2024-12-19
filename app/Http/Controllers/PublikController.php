<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\Infografis;
use App\Models\Kontak;
use App\Models\Lokasi;
use App\Models\Tentang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublikController extends Controller
{
    //Fungsi untuk halaman coming
    public function coming()
    {
        return view('pages.public.coming', [
            'judul' =>  'Coming Soon',
        ]);
    }

    //Fungsi untuk halaman beranda
    public function beranda()
    {
        return view('pages.public.beranda', [
            'judul' => 'Beranda',
            'jI' => Infografis::where('visib_infografis', 'Tampilkan')->count(),
            'Infografis' => Infografis::where('visib_infografis', 'Tampilkan')->latest()->limit(3)->get(),
            'jK' => Kontak::where('visib_kontak', 'Tampilkan')->count(),
            'Kontak' => Kontak::where('visib_kontak', 'Tampilkan')->latest()->limit(1)->get(),
            'jL' => Lokasi::where('visib_lokasi', 'Tampilkan')->count(),
            'Lokasi' => Lokasi::where('visib_lokasi', 'Tampilkan')->latest()->get(),
        ]);
    }

    //Fungsi untuk halaman tentang
    public function tentang()
    {
        return view('pages.public.tentang', [
            'judul' => 'Tentang Desa Kedungbanteng',
            'jT' => Tentang::where('visib_tentang', 'Tampilkan')->count(),
            'Tentang' => Tentang::where('visib_tentang', 'Tampilkan')->latest()->limit(1)->get(),
        ]);
    }

    //Fungsi untuk halaman infografis
    public function infografis()
    {
        return view('pages.public.infografis', [
            'judul' => 'Infografis',
            // 'jI' => Edukasi::where('visib_edukasi', 'Tampilkan')->count(),
            'jI' => Infografis::where('visib_infografis', 'Tampilkan')->count(),
            'Infografis' => Infografis::where('visib_infografis', 'Tampilkan')->latest()->get(),
        ]);
    }

    //Fungsi untuk halaman edukasi
    public function edukasi()
    {
        $edukasiData = Edukasi::where('visib_edukasi', 'Tampilkan')->latest()->get();

        $edukasiData->map(function ($item) {
            $item->format_tgl = $this->formatTimestamp($item->created_at);
            return $item;
        });

        return view('pages.public.edukasi', [
            'judul' => 'Edukasi Bencana',
            'jE' => Edukasi::where('visib_edukasi', 'Tampilkan')->count(),
            'Edukasi' => $edukasiData,
        ]);
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
