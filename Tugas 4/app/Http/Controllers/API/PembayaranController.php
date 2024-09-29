<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $pembayaran = Pembayaran::where('transaksi_id', $id)->first();
        if (!$pembayaran) {
            return $this->sendError('Pembayaran tidak ditemukan.', 404);
        }
        $data = [
            'bukti_pembayaran' => Storage::url($pembayaran->bukti_pembayaran),
        ];

        return $this->sendResponse($data);
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
