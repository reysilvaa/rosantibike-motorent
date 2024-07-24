<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMotor extends Model
{
    use HasFactory;

    protected $table = 'jenis_motor';

    protected $fillable = [
        'merk',
        'nopol',
        'harga_perHari',
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_jenis');
    }

}
