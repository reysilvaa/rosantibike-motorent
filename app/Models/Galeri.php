<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'id_user',
        'judul',
        'deskripsi',
        'full_description',
        'foto',
        'kategori',
        'link_maps',
    ];
    public $timestamps = false;

    // Optional: Define relationships, if any
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
