<?php

namespace App\Http\Controllers;

use App\Models\LaporanStok;
use App\Http\Requests\StoreLaporanStokRequest;
use App\Http\Requests\UpdateLaporanStokRequest;

class LaporanStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = LaporanStok::with('stokObat')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('laporan_stok.data', compact('data'));
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
    public function store(StoreLaporanStokRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanStok $laporanStok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanStok $laporanStok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanStokRequest $request, LaporanStok $laporanStok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanStok $laporanStok)
    {
        //
    }
}
