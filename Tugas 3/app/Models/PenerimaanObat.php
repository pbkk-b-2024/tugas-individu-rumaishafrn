<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanObat extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_obat';

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
