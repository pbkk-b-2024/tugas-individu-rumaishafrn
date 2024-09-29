<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPenjualan;

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
