<?php

namespace App\Http\Controllers;

use App\Models\Infografis;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'judul' => 'Data Infografis',
            'DataInfografis' => Infografis::latest()->get(),
        ];
        return view('pages.admin.v_infografis', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'judul' => 'Tambah Infografis',
        ];
        return view('pages.admin.v_infografis_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validate form
        $request->validate([
            'Foto'      => 'required|image|mimes:jpeg,jpg,png|max:3072',
            'Judul'     => 'required|max:255',
            'Sumber'    => 'required|max:255',
        ]);

        //upload image
        $foto = $request->file('Foto');
        $fotoName = time().Str::random(17).'.'.$foto->getClientOriginalExtension();
        $foto->move('assets/foto/infografis/', $fotoName);

        //create
        Infografis::create([
            'id_infografis'     => 'Infografis'.Str::random(33),
            'judul_infografis'  => $request->Judul,
            'sumber_infografis' => $request->Sumber,
            'foto_infografis'   => $fotoName,
            'visib_infografis'  => $request->visibilitas,
            'created_by'    => Auth::user()->email,
            'modified_by'   => Auth::user()->email,
        ]);

        //redirect to index
        return redirect()->route('infografis.tambah')->with(['success' => 'Infografis Berhasil Ditambahkan!']);
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
    public function edit(string $id)
    {
        $data = [
            'judul' => 'Edit Infografis',
            'EditInfografis' => Infografis::findOrFail($id),
        ];
        return view('pages.admin.v_infografis_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate form
        $request->validate([
            'Foto'      => 'image|mimes:jpeg,jpg,png|max:3072',
            'Judul'     => 'required|max:255',
            'Sumber'    => 'required|max:255',
        ]);

        //get by ID
        $infografis = Infografis::findOrFail($id);

        //cek gambar di upload
        if ($request->hasFile('Foto')) {
            $infografis_path = 'assets/foto/infografis/' . $infografis->foto_infografis;
            if (file_exists($infografis_path)) {
                unlink($infografis_path);
            }
            //upload image
            $foto = $request->file('Foto');
            $fotoName = time().Str::random(17).'.'.$foto->getClientOriginalExtension();
            $foto->move('assets/foto/infografis/', $fotoName);

            //update
            $infografis->update([
                'judul_infografis'  => $request->Judul,
                'sumber_infografis' => $request->Sumber,
                'foto_infografis'   => $fotoName,
                'visib_infografis'  => $request->visibilitas,
                'modified_by'   => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('infografis.data')->with(['success' => 'Infografis Berhasil Diperbarui!']);
        }else{
            //update
            $infografis->update([
                'judul_infografis'  => $request->Judul,
                'sumber_infografis' => $request->Sumber,
                'visib_infografis'  => $request->visibilitas,
                'modified_by'   => Auth::user()->email,
            ]);

            //redirect to index
            return redirect()->route('infografis.data')->with(['success' => 'Infografis Berhasil Diperbarui!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get by ID
        $infografis = Infografis::findOrFail($id);

        //delete image
        $infografis_path = 'assets/foto/infografis/' . $infografis->foto_infografis;
        if (file_exists($infografis_path)) {
            unlink($infografis_path);
        }

        //delete
        $infografis->delete();

        //redirect to index
        return redirect()->route('infografis.data')->with(['success' => 'Infografis Berhasil Dihapus!']);
    }
}
