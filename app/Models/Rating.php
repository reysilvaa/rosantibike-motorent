<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating'; // Define the table associated with the model

    protected $fillable = [
        'nama',
        'deskripsi',
        'role',
        'rating',
        'tanggal',
    ];
    protected $dates = [
        'tanggal',
    ];

    public function getTanggalAttribute($value)
    {
        return Carbon::parse($value);
    }
    public $timestamps = false;

}
