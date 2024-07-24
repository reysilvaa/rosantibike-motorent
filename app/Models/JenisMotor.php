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

    // public function calculateHarga($tgl_sewa, $tgl_kembali)
    // {
    //     $harga_perHari = $this->harga_perHari;
    //     $tgl_sewa = Carbon::parse($tgl_sewa);
    //     $tgl_kembali = Carbon::parse($tgl_kembali);
    //     $jumlah_hari = $tgl_sewa->diffInDays($tgl_kembali);

    //     return $harga_perHari * $jumlah_hari;
    // }
}
