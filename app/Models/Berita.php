<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'user_id', 
        'judul', 
        'isi', 
        'kategori', 
        'gambar', 
        'tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}