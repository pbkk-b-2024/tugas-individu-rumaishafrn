<?php

namespace App\Models;

use App\Models\Pembayaran;
use App\Models\PenerimaanObat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getBuktiPembayaranAttribute()
    {
        return Pembayaran::where('transaksi_id', $this->id)->first();
    }
}
