<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBencana extends Model
{
    protected $table = 'jenis_bencana';
    protected $fillable = ['nama_jenis', 'deskripsi'];

    public function kejadianBencana()
    {
        return $this->hasMany(KejadianBencana::class, 'jenis_bencana_id');
    }

    public function wilayahRawan()
    {
        return $this->hasMany(WilayahRawan::class, 'jenis_bencana_id');
    }
}
