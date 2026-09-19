<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahRawan extends Model
{
    protected $table = 'wilayah_rawan';

    protected $fillable = [
        'wilayah_id',
        'jenis_bencana_id',
        'tingkat_kerawanan',
        'keterangan',
        'polygon',
    ];

    protected $casts = [
        'polygon' => 'array',
    ];
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function jenisBencana()
    {
        return $this->belongsTo(JenisBencana::class, 'jenis_bencana_id');
    }
}