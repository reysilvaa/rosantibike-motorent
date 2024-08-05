<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';

    protected $fillable = [
        'merk',
        'harga_perHari',
        'foto',
        'judul',
        'deskripsi1',
        'deskripsi2',
        'deskripsi3',
        'kategori',
    ];
    public $timestamps = false;

    public function jenisMotor()
    {
        return $this->hasMany(JenisMotor::class, 'id_stok', 'id');
    }
}
