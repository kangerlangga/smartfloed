<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\Infografis;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //Fungsi untuk halaman dashboard
    public function index()
    {
        $data = [
            'judul' => 'Dashboard',
            'jIs' => Infografis::where('visib_infografis', 'Tampilkan')->count(),
            'jIh' => Infografis::where('visib_infografis', 'Sembunyikan')->count(),
            'jLs' => Lokasi::where('visib_lokasi', 'Tampilkan')->count(),
            'jLh' => Lokasi::where('visib_lokasi', 'Sembunyikan')->count(),
            'jEs' => Edukasi::where('visib_edukasi', 'Tampilkan')->count(),
            'jEh' => Edukasi::where('visib_edukasi', 'Sembunyikan')->count(),
            'jL' => Lokasi::where('visib_lokasi', 'Tampilkan')->count(),
            'Lokasi' => Lokasi::where('visib_lokasi', 'Tampilkan')->latest()->get(),
        ];
        return view('pages.admin.v_dashboard', $data);
    }

    //Fungsi untuk halaman profil
    public function editProf()
    {
        $data = [
            'judul' => 'Akun Saya',
        ];
        return view('pages.admin.v_profil_edit', $data);
    }

    public function updateProf(Request $request)
    {
        $passProf = User::findOrFail(Auth::user()->id);

        if (password_verify($request->password, $passProf->password)) {
            // validate form
            $request->validate([
                'nama'         => 'required|max:45',
                'alamat'       => 'required|max:255',
                'jabatan'      => 'required|max:255',
                'telp'         => 'required|numeric|max_digits:13',
            ]);

            //get by ID
            $profil = User::findOrFail(Auth::user()->id);

            //update
            $profil->update([
                'nama'        => $request->nama,
                'alamat'      => $request->alamat,
                'jabatan'     => $request->jabatan,
                'telp'        => $request->telp,
                'modified_by' => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('admin.dash')->with(['successprof' => 'Informasi Akun Anda Berhasil Diperbarui!']);
        }else{
            return redirect()->route('prof.edit')->with(['passerror' => 'Password Anda Salah!']);
        }
    }

    public function editPass()
    {
        $data = [
            'judul' => 'Ganti Password Akun',
        ];
        return view('pages.admin.v_profil_editPass', $data);
    }

    public function updatePass(Request $request)
    {
        $passEdit = User::findOrFail(Auth::user()->id);

        if (password_verify($request->oldPass, $passEdit->password)) {
            // validate form
            $request->validate([
                'confirmPass'  => 'required|same:newPass',
            ]);

            //get by ID
            $profil = User::findOrFail(Auth::user()->id);

            $newPass = password_hash($request->newPass, PASSWORD_DEFAULT);

            //update
            $profil->update([
                'password'    => $newPass,
                'modified_by' => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('prof.edit.pass')->with(['success' => 'Password Akun Anda Berhasil Diperbarui!']);
        }else{
            return redirect()->route('prof.edit.pass')->with(['error' => 'Password Lama Anda Salah!']);
        }
    }
}
