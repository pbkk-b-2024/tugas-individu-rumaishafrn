<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokObat;
use App\Models\LaporanStok;
use App\Http\Requests\StoreStokObatRequest;
use App\Http\Requests\UpdateStokObatRequest;
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
        return view('stok_obat.data', compact('data'));
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
    public function store(StoreStokObatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StokObat $stok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $stok)
    {
        //
        $obat = $stok;
        return view('stok_obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStokObatRequest $request, Obat $stok)
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
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }

        $stok_obat = new StokObat();
        $stok_obat->obat_id = $stok->id;
        $stok_obat->jumlah_stok = $validated['jumlah_stok'];
        $stok_obat->save();

        $laporan_stok = new LaporanStok();
        $laporan_stok->stok_obat_id = $stok_obat->id;
        $laporan_stok->total_stok = $stok->stok;
        $laporan_stok->save();

        return redirect('stok')->with('success', 'Stok berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokObat $stok)
    {
        //
    }
}
