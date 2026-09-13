<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JenisBencana;
use App\Models\Wilayah;

class KejadianBencana extends Model
{
    protected $table = 'kejadian_bencana';

    protected $fillable = [
        'user_id',
        'verified_by',
        'jenis_bencana_id',
        'wilayah_id',
        'judul',
        'deskripsi',
        'tanggal_kejadian',
        'gambar',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'datetime',
    ];

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function jenisBencana()
    {
        return $this->belongsTo(JenisBencana::class, 'jenis_bencana_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}