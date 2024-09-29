<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Obat;
use App\Models\Pembayaran;
use App\Models\PenerimaanObat;
use App\Models\LaporanPenjualan;
use App\Models\LaporanStok;
use App\Models\StokObat;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Transaksi::with(['obat', 'user'])
            ->when(Gate::denies('confirm-transaksi'), function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($data as $d) {
            $d->bukti_pembayaran = $d->bukti_pembayaran;
            $d->obat_gambar = Storage::url($d->obat->gambar);
        }
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
                    'obat_id' => 'required',
                    'jumlah' => 'required',
                ],
                [
                    'obat_id.required' => 'Obat harus dipilih',
                    'jumlah.required' => 'Jumlah harus diisi',
                ]
            );
        } catch (ValidationException $e) {
            return $this->sendError('form error', $e->errors());
        }

        $obat = Obat::find($request->obat_id);
        if ($obat->stok < $request->jumlah) {
            return $this->sendError('Stok obat tidak mencukupi');
        }

        $transaksi = new Transaksi();
        $transaksi->user_id = Auth::user()->role != 'pelanggan' ? $request->user_id : Auth::user()->id;
        $transaksi->obat_id = $validated['obat_id'];
        $transaksi->jumlah = $validated['jumlah'];
        $transaksi->total_harga = $obat->harga * $validated['jumlah'];
        $transaksi->save();

        return $this->sendResponse($transaksi, 'Transaksi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $transaksi = Transaksi::with(['obat', 'user'])->find($id);
        if (!$transaksi) {
            return $this->sendError('Transaksi tidak ditemukan', [], 404);
        }
        if (Auth::user()->role == 'pelanggan' && Auth::user()->id != $transaksi->user_id) {
            return $this->sendError('Transaksi tidak ditemukan', [], 404);
        }
        return $this->sendResponse($transaksi);
    }

    public function bukti(string $id)
    {
        //
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return $this->sendError('Transaksi tidak ditemukan', [], 404);
        }
        if (Auth::user()->role == 'pelanggan' && Auth::user()->id != $transaksi->user_id) {
            return $this->sendError('Transaksi tidak ditemukan', [], 404);
        }

        try {
            $validated = request()->validate(
                [
                    'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'bukti_pembayaran.required' => 'Bukti pembayaran harus diisi',
                    'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar',
                    'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa gambar dengan format jpeg, png, jpg',
                    'bukti_pembayaran.max' => 'Bukti pembayaran tidak boleh lebih dari 2MB',
                ]
            );
        } catch (ValidationException $e) {
            return $this->sendError('form error', $e->errors());
        }

        $pembayaran = new Pembayaran();
        $pembayaran->transaksi_id = $transaksi->id;
        $pembayaran->bukti_pembayaran = $validated['bukti_pembayaran']->store('bukti_pembayaran', 'public');
        $pembayaran->save();

        return $this->sendResponse($pembayaran, 'Bukti pembayaran berhasil diunggah');
    }

    public function confirm(string $id)
    {
        //
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return $this->sendError('Transaksi tidak ditemukan', [], 404);
        }
        $pembayaran = Pembayaran::where('transaksi_id', $transaksi->id)->first();
        if (!$pembayaran) {
            return $this->sendError('Bukti pembayaran belum diunggah');
        }

        $pembayaran->status = 'paid';
        $pembayaran->save();

        $penerimaan = new PenerimaanObat();
        $penerimaan->user_id = $transaksi->user_id;
        $penerimaan->obat_id = $transaksi->obat_id;
        $penerimaan->jumlah_penerimaan = $transaksi->jumlah;
        $penerimaan->save();

        $laporan = new LaporanPenjualan();
        $laporan->transaksi_id = $transaksi->id;
        $laporan->jumlah_penjualan = $transaksi->jumlah;
        $laporan->total_harga_penjualan = $transaksi->total_harga;
        $laporan->save();

        $stok = new StokObat();
        $stok->obat_id = $transaksi->obat_id;
        $stok->jumlah_stok = -$transaksi->jumlah;
        $stok->save();

        $obat = Obat::find($transaksi->obat_id);
        $laporan_stok = new LaporanStok();
        $laporan_stok->stok_obat_id = $stok->id;
        $laporan_stok->total_stok = $obat->stok;
        $laporan_stok->save();

        return $this->sendResponse($transaksi, 'Transaksi berhasil dikonfirmasi');
    }

    public function reject(string $id)
    {
        //
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return $this->sendError('Transaksi tidak ditemukan', [], 404);
        }
        $pembayaran = Pembayaran::where('transaksi_id', $transaksi->id)->first();
        if (!$pembayaran) {
            return $this->sendError('Bukti pembayaran belum diunggah');
        }

        $pembayaran->status = 'cancel';
        $pembayaran->save();

        return $this->sendResponse($transaksi, 'Transaksi berhasil ditolak');
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
