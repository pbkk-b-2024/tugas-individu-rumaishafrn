<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use App\Models\Obat;
use App\Models\StokObat;
use App\Models\Pembayaran;
use App\Models\PenerimaanObat;
use App\Models\LaporanPenjualan;
use App\Models\LaporanStok;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;

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
        return view('transaksi.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = User::where('role', 'pelanggan')->get();
        $obat = Obat::all();
        foreach ($obat as $o) {
            if ($o->stok <= 0) {
                $obat = $obat->reject(function ($value, $key) use ($o) {
                    return $value->id == $o->id;
                });
            }
        }
        return view('transaksi.add', compact('user', 'obat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
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
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $obat = Obat::find($request->obat_id);
        if ($obat->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok obat tidak mencukupi')->withInput();
        }

        $transaksi = new Transaksi();
        $transaksi->user_id = $request->user_id ?? Auth::user()->id;
        $transaksi->obat_id = $validated['obat_id'];
        $transaksi->jumlah = $validated['jumlah'];
        $transaksi->total_harga = $obat->harga * $validated['jumlah'];
        $transaksi->save();

        return redirect('transaksi')->with('success', 'Transaksi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
        if (Auth::user()->role == 'pelanggan' && Auth::user()->id != $transaksi->user_id) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }
        return view('transaksi.bukti', compact('transaksi'));
    }


    public function bukti(Transaksi $transaksi)
    {
        //
        if (Auth::user()->role == 'pelanggan' && Auth::user()->id != $transaksi->user_id) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
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
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $pembayaran = new Pembayaran();
        $pembayaran->transaksi_id = $transaksi->id;
        $pembayaran->bukti_pembayaran = $validated['bukti_pembayaran']->store('bukti_pembayaran', 'public');
        $pembayaran->save();

        return redirect('transaksi')->with('success', 'Bukti pembayaran berhasil diunggah, menunggu konfirmasi');
    }

    public function confirm(Transaksi $transaksi)
    {
        //
        $pembayaran = Pembayaran::where('transaksi_id', $transaksi->id)->first();
        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Bukti pembayaran belum diunggah');
        }

        $pembayaran->status = 'paid';
        $pembayaran->save();

        $penerimaan = new PenerimaanObat();
        $penerimaan->user_id = $transaksi->user_id;
        $penerimaan->obat_id = $transaksi->obat_id;
        $penerimaan->jumlah_penerimaan = $transaksi->jumlah;
        $penerimaan->save();

        $stok = new StokObat();
        $stok->obat_id = $transaksi->obat_id;
        $stok->jumlah_stok = -$transaksi->jumlah;
        $stok->save();

        return redirect('transaksi')->with('success', 'Transaksi berhasil dikonfirmasi');
    }

    public function reject(Transaksi $transaksi)
    {
        //
        $pembayaran = Pembayaran::where('transaksi_id', $transaksi->id)->first();
        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Bukti pembayaran belum diunggah');
        }

        $pembayaran->status = 'cancel';
        $pembayaran->save();

        return redirect('transaksi')->with('success', 'Transaksi berhasil ditolak');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
