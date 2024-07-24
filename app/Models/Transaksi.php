<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_user',
        'id_jenis',
        'nama_penyewa',
        'wa1',
        'wa2',
        'wa3',
        'tgl_sewa',
        'tgl_kembali',
        'status',
        'total',
    ];

    protected $casts = [
        'tgl_sewa' => 'date',
        'tgl_kembali' => 'date',
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function jenisMotor()
    {
        return $this->belongsTo(JenisMotor::class, 'id_jenis');
    }


    public static function createTransaction($data)
    {
        return self::create(array_merge($data, [
            'status' => 'disewa',
            'id_user' => 1 //ganti ke login user
        ]));
    }

    public function updateTransaction($data)
    {
        $jenis_motor = JenisMotor::find($data['id_jenis']);
        $total = $jenis_motor->calculateHarga($data['tgl_sewa'], $data['tgl_kembali']);

        $this->update(array_merge($data, ['total' => $total]));
    }
}
