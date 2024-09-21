<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenjualan extends Model
{
    use HasFactory;

    protected $table = 'laporan_penjualan';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }
}
