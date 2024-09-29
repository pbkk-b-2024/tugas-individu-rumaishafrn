<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\KategoriObat;
use App\Http\Requests\StoreObatRequest;
use App\Http\Requests\UpdateObatRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $data = Obat::all();
        $data = [];
        $kategori = KategoriObat::all();
        return view('obat.data', compact('data', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Gate::denies('manage-obat')) {
            return abort(403, 'Anda tidak memiliki hak akses');
        }
        $kategori = KategoriObat::all();
        return view('obat.add', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObatRequest $request)
    {
        //
        if (Gate::denies('manage-obat')) {
            return abort(403, 'Anda tidak memiliki hak akses');
        }
        try {
            $validated = request()->validate(
                [
                    'nama_obat' => 'required',
                    'deskripsi' => 'required',
                    'harga' => 'required',
                    'kategori_id' => 'required',
                    'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                ],
                [
                    'nama_obat.required' => 'Nama obat harus diisi',
                    'deskripsi.required' => 'Deskripsi harus diisi',
                    'harga.required' => 'Harga harus diisi',
                    'kategori_id.required' => 'Kategori harus dipilih',
                    'gambar.required' => 'Gambar harus diupload',
                    'gambar.image' => 'File harus berupa gambar',
                    'gambar.mimes' => 'File harus berformat jpeg, png, jpg',
                    'gambar.max' => 'Ukuran file maksimal 2MB'
                ]
            );
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $obat = new Obat();
        $obat->nama_obat = $validated['nama_obat'];
        $obat->deskripsi = $validated['deskripsi'];
        $obat->harga = $validated['harga'];
        $obat->kategori_id = $validated['kategori_id'];
        $obat->gambar = $validated['gambar']->store('obat', 'public');
        $obat->save();

        return redirect('obat')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Obat $obat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat)
    {
        //
        if (Gate::denies('manage-obat')) {
            return abort(403, 'Anda tidak memiliki hak akses');
        }
        $kategori = KategoriObat::all();
        $data = $obat;
        return view('obat.edit', compact('kategori', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObatRequest $request, Obat $obat)
    {
        //
        if (Gate::denies('manage-obat')) {
            return abort(403, 'Anda tidak memiliki hak akses');
        }
        try {
            $validated = request()->validate(
                [
                    'nama_obat' => 'required',
                    'deskripsi' => 'required',
                    'harga' => 'required',
                    'kategori_id' => 'required',
                    'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
                ],
                [
                    'nama_obat.required' => 'Nama obat harus diisi',
                    'deskripsi.required' => 'Deskripsi harus diisi',
                    'harga.required' => 'Harga harus diisi',
                    'kategori_id.required' => 'Kategori harus dipilih',
                    'gambar.image' => 'File harus berupa gambar',
                    'gambar.mimes' => 'File harus berformat jpeg, png, jpg',
                    'gambar.max' => 'Ukuran file maksimal 2MB'
                ]
            );
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $obat->nama_obat = $validated['nama_obat'];
        $obat->deskripsi = $validated['deskripsi'];
        $obat->harga = $validated['harga'];
        $obat->kategori_id = $validated['kategori_id'];
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($obat->gambar);
            $obat->gambar = $validated['gambar']->store('obat', 'public');
        }
        $obat->save();

        return redirect('obat')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $obat)
    {
        //
        if (Gate::denies('manage-obat')) {
            return abort(403, 'Anda tidak memiliki hak akses');
        }
        Storage::disk('public')->delete($obat->gambar);
        $obat->delete();
        return redirect('obat')->with('success', 'Data berhasil dihapus');
    }
}
