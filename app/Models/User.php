<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

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
