<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;

    protected $table = 'stok_obat';

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
}
