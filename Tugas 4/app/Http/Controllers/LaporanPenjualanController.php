<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenjualan;
use App\Http\Requests\StoreLaporanPenjualanRequest;
use App\Http\Requests\UpdateLaporanPenjualanRequest;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = LaporanPenjualan::with('transaksi')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->transaksi->obat_id . '|' . $item->created_at->format('Y-m-d');
            })
            ->map(function ($item) {
                // return $item->sum('jumlah_penjualan');
                return (object) [
                    'obat' => $item->first()->transaksi->obat,
                    'jumlah_penjualan' => $item->sum('jumlah_penjualan'),
                    'total_harga_penjualan' => $item->sum('total_harga_penjualan'),
                    'tanggal' => $item->first()->created_at->format('d-m-Y')
                ];
            });
        return view('laporan_penjualan.data', compact('data'));
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
    public function store(StoreLaporanPenjualanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPenjualan $laporanPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPenjualan $laporanPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanPenjualanRequest $request, LaporanPenjualan $laporanPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanPenjualan $laporanPenjualan)
    {
        //
    }
}
