<?php

namespace App\Models;

use App\Models\StokObat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id', 'id');
    }

    public function getStokAttribute()
    {
        return StokObat::where('obat_id', $this->id)->sum('jumlah_stok');
    }
}
