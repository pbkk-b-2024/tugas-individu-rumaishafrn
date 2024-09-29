<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use App\Models\KategoriObat;
use Illuminate\Http\Request;
use App\Models\Obat;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Obat::with('kategori')->get();
        foreach ($data as $obat) {
            $obat->gambar = Storage::url($obat->gambar);
            $obat->stok = $obat->stok;
        }
        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (Gate::denies('manage-obat')) {
            return $this->sendError('Anda tidak memiliki hak akses', [], 403);
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
            return $this->sendError('form error', $e->errors());
        }

        $obat = new Obat();
        $obat->nama_obat = $validated['nama_obat'];
        $obat->deskripsi = $validated['deskripsi'];
        $obat->harga = $validated['harga'];
        $obat->kategori_id = $validated['kategori_id'];
        $obat->gambar = $validated['gambar']->store('obat', 'public');
        $obat->save();

        return $this->sendResponse($obat, 'Obat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $obat)
    {
        //
        $obat = Obat::find($obat);
        if (!$obat) {
            return $this->sendError('Obat tidak ditemukan');
        }
        return $this->sendResponse($obat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $obat)
    {
        //
        if (Gate::denies('manage-obat')) {
            return $this->sendError('Anda tidak memiliki hak akses', [], 403);
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
            return $this->sendError('Validation error', $e->errors());
        }

        $obat = Obat::find($obat);
        if (!$obat) {
            return $this->sendError('Obat tidak ditemukan', [], 404);
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

        return $this->sendResponse($obat, 'Obat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $obat)
    {
        //
        if (Gate::denies('manage-obat')) {
            return $this->sendError('Anda tidak memiliki hak akses', [], 403);
        }
        $obat = Obat::find($obat);
        if (!$obat) {
            return $this->sendError('Obat tidak ditemukan', [], 404);
        }
        Storage::disk('public')->delete($obat->gambar);
        $obat->delete();
        return $this->sendResponse($obat, 'Obat berhasil dihapus.');
    }
}
