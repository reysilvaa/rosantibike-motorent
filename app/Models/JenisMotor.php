<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMotor extends Model
{
    use HasFactory;

    protected $table = 'jenis_motor';

    protected $fillable = [
        'id_stok',
        'status',
        'nopol',
        'created_at',
        'updated_at',
    ];
    public $timestamps = false;

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'id_stok', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_jenis', 'id');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_jenis', 'id');
    }
}
