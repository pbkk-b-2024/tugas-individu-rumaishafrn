<?php

namespace App\Http\Controllers;

use App\Models\KategoriObat;
use App\Http\Requests\StoreKategoriObatRequest;
use App\Http\Requests\UpdateKategoriObatRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class KategoriObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $data = KategoriObat::all();
        $data = [];
        return view('kategori_obat.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('kategori_obat.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriObatRequest $request)
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
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $kategori_obat = new KategoriObat();
        $kategori_obat->nama_kategori = $validated['nama_kategori'];
        $kategori_obat->save();

        return redirect('kategori')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriObat $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriObat $kategori)
    {
        //
        $data = KategoriObat::find($kategori->id);
        return view('kategori_obat.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriObatRequest $request, KategoriObat $kategori)
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
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $kategori->nama_kategori = $validated['nama_kategori'];
        $kategori->save();

        return redirect('kategori')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriObat $kategori)
    {
        //
        $kategori->delete();

        return redirect('kategori')->with('success', 'Data berhasil dihapus');
    }
}
