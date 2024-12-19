<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->level == 'Super Admin') {
            $data = [
                'judul' => 'Data Akun',
                'DataAkun' => User::latest()->get(),
            ];
            return view('pages.admin.v_akun', $data);
        }else{
            return redirect()->route('admin.dash');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->level == 'Super Admin') {
            $data = [
                'judul' => 'Buat Akun Baru',
            ];
            return view('pages.admin.v_akun_add', $data);
        }else{
            return redirect()->route('admin.dash');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->level == 'Super Admin') {
            //validate form
            $request->validate([
                'Nama'         => 'required|max:45',
                'Email'        => 'required|email|unique:users|max:255',
                'Alamat'       => 'required|max:255',
                'Jabatan'      => 'required|max:255',
                'Telp'         => 'required|numeric|max_digits:13',
            ]);

            $defPass = 'Banjir#SMARTFLOED.Bisa272';
            $sandi = password_hash($defPass, PASSWORD_DEFAULT);
            //create akun
            User::create([
                'id_akun'       => 'Akun'.Str::random(33),
                'nama'          => $request->Nama,
                'email'         => $request->Email,
                'password'      => $sandi,
                'alamat'        => $request->Alamat,
                'jabatan'       => $request->Jabatan,
                'telp'          => $request->Telp,
                'level'         => $request->Level,
                'created_by'    => Auth::user()->email,
                'modified_by'   => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('akun.tambah')->with(['success' => 'Akun Berhasil Ditambahkan!']);
        }else{
            return redirect()->route('admin.dash');
        }
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
    public function edit(string $id_akun)
    {
        if (Auth::user()->level == 'Super Admin') {
            //get by ID
            $getID = User::where('id_akun', $id_akun)->first();
            $akun = User::findOrFail($getID->id);
            if ($akun->id_akun == Auth::user()->id_akun) {
                //redirect to index
                return redirect()->route('prof.edit');
            }else{
                $data = [
                    'judul' => 'Edit Akun',
                    'EditAkun' => $akun,
                ];
                return view('pages.admin.v_akun_edit', $data);
            }
        }else{
            return redirect()->route('admin.dash');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_akun)
    {
        if (Auth::user()->level == 'Super Admin') {
            //validate form
            $request->validate([
                'Nama'         => 'required|max:45',
                'Alamat'       => 'required|max:255',
                'Jabatan'      => 'required|max:255',
                'Telp'         => 'required|numeric|max_digits:13',
            ]);

            $getID = User::where('id_akun', $id_akun)->first();
            $akun = User::findOrFail($getID->id);

            //update
            $akun->update([
                'nama'          => $request->Nama,
                'alamat'        => $request->Alamat,
                'jabatan'       => $request->Jabatan,
                'telp'          => $request->Telp,
                'level'         => $request->Level,
                'modified_by'   => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('akun.data')->with(['success' => 'Akun Berhasil Diedit!']);
        }else{
            return redirect()->route('admin.dash');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_akun)
    {
        if (Auth::user()->level == 'Super Admin') {
            //get by ID
            $getID = User::where('id_akun', $id_akun)->first();
            $akun = User::findOrFail($getID->id);
            if ($akun->id_akun == Auth::user()->id_akun) {
                //redirect to index
                return redirect()->route('akun.data')->with(['error' => 'Akun Gagal Dihapus!']);
            }else{
                //delete
                $akun->delete();
                //redirect to index
                return redirect()->route('akun.data')->with(['success' => 'Akun Berhasil Dihapus!']);
            }
        }else{
            return redirect()->route('admin.dash');
        }
    }

    public function resetPass(string $id_akun)
    {
        if (Auth::user()->level == 'Super Admin') {
            //get by ID
            $getID = User::where('id_akun', $id_akun)->first();
            $akun = User::findOrFail($getID->id);
            if ($akun->id_akun == Auth::user()->id_akun) {
                //redirect to index
                return redirect()->route('akun.data')->with(['error' => 'Password Gagal Direset!']);
            }else{
                $defPass = 'Banjir#SMARTFLOED.Bisa272';
                $sandi = password_hash($defPass, PASSWORD_DEFAULT);
                //update
                $akun->update([
                    'password'    => $sandi,
                    'modified_by' => Auth::user()->email,
                ]);
                //redirect to index
                return redirect()->route('akun.data')->with(['success' => 'Password Berhasil Direset!']);
            }
        }else{
            return redirect()->route('admin.dash');
        }
    }
}
