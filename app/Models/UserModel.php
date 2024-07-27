<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'uname',
        'pass',
    ];

    protected $hidden = [
        'pass',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_user');
    }
}
