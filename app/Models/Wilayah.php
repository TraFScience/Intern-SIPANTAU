<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = ['nama_wilayah', 'tipe', 'latitude', 'longitude'];

    public function kejadianBencana()
    {
        return $this->hasMany(KejadianBencana::class, 'wilayah_id');
    }

    public function wilayahRawan()
    {
        return $this->hasMany(WilayahRawan::class, 'wilayah_id');
    }
}