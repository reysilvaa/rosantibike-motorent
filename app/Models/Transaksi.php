<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_jenis',
        'nama_penyewa',
        'alamat',
        'wa1',
        'wa2',
        'wa3',
        'tgl_sewa',
        'tgl_kembali',
        'helm',
        'jashujan',
        'total',
    ];

    protected $casts = [
        'tgl_sewa' => 'datetime',
        'tgl_kembali' => 'datetime',
        'total' => 'decimal:2',
    ];


    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user');
    // }

    public function jenisMotor()
    {
        return $this->belongsTo(JenisMotor::class, 'id_jenis', 'id');
    }

    public function getDurationAttribute()
    {
        return $this->tgl_sewa->diffInDays($this->tgl_kembali) + 1;
    }
}
