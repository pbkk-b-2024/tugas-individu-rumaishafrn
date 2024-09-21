<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanStok extends Model
{
    use HasFactory;

    protected $table = 'laporan_stok';

    public function stokObat()
    {
        return $this->belongsTo(StokObat::class, 'stok_obat_id', 'id');
    }
}
