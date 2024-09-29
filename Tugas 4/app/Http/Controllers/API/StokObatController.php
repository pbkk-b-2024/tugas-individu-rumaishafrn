<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\StokObat;
use App\Models\LaporanStok;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class StokObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Obat::all();
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $stok = Obat::find($id);
        if (!$stok) {
            return $this->sendError('Obat tidak ditemukan', [], 404);
        }
        $stok->gambar = Storage::url($stok->gambar);
        $stok->stok = $stok->stok;
        return $this->sendResponse($stok);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $validated = request()->validate(
                [
                    'jumlah_stok' => 'required|min:1'
                ],
                [
                    'jumlah_stok.required' => 'Jumlah stok harus diisi',
                    'jumlah_stok.min' => 'Jumlah stok minimal 1'
                ]
            );
        } catch (ValidationException $e) {
            return $this->sendError('form error', $e->errors());
        }

        $stok = Obat::find($id);
        if (!$stok) {
            return $this->sendError('Obat tidak ditemukan', [], 404);
        }

        $stok_obat = new StokObat();
        $stok_obat->obat_id = $stok->id;
        $stok_obat->jumlah_stok = $validated['jumlah_stok'];
        $stok_obat->save();

        $laporan_stok = new LaporanStok();
        $laporan_stok->stok_obat_id = $stok_obat->id;
        $laporan_stok->total_stok = $stok->stok;
        $laporan_stok->save();

        return $this->sendResponse($stok_obat, 'Stok obat berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
