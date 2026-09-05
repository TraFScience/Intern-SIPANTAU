<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $fillable = ['user_id', 'judul', 'isi', 'gambar', 'tanggal'];

    public function me()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}