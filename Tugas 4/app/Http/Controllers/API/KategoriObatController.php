<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\KategoriObat;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class KategoriObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = KategoriObat::all();
        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validated = request()->validate(
                [
                    'nama_kategori' => 'required'
                ],
                [
                    'nama_kategori.required' => 'Nama kategori harus diisi'
                ]
            );
        } catch (ValidationException $e) {
            return $this->sendError('form error', $e->errors());
        }

        $kategori_obat = new KategoriObat();
        $kategori_obat->nama_kategori = $validated['nama_kategori'];
        $kategori_obat->save();

        return $this->sendResponse($kategori_obat, 'Kategori obat berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kategori)
    {
        //
        $kategori = KategoriObat::find($kategori);
        if (!$kategori) {
            return $this->sendError('Kategori obat tidak ditemukan', [], 404);
        }
        return $this->sendResponse($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kategori)
    {
        //
        try {
            $validated = request()->validate(
                [
                    'nama_kategori' => 'required'
                ],
                [
                    'nama_kategori.required' => 'Nama kategori harus diisi'
                ]
            );
        } catch (ValidationException $e) {
            return $this->sendError('form error', $e->errors());
        }

        $kategori = KategoriObat::find($kategori);
        if (!$kategori) {
            return $this->sendError('Kategori obat tidak ditemukan', [], 404);
        }
        $kategori->nama_kategori = $validated['nama_kategori'];
        $kategori->save();

        return $this->sendResponse($kategori, 'Kategori obat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kategori)
    {
        //
        $kategori = KategoriObat::find($kategori);
        if (!$kategori) {
            return $this->sendError('Kategori obat tidak ditemukan', [], 404);
        }
        $kategori->delete();

        return $this->sendResponse($kategori, 'Kategori obat berhasil dihapus');
    }
}
