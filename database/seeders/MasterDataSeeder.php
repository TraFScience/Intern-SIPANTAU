<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBencana;
use App\Models\Wilayah;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Isi data awal jenis bencana
        JenisBencana::create(['nama_jenis' => 'Banjir']);
        JenisBencana::create(['nama_jenis' => 'Tanah Longsor']);
        JenisBencana::create(['nama_jenis' => 'Puting Beliung']);
        JenisBencana::create(['nama_jenis' => 'Kebakaran Hutan']);

        // 2. Isi data awal wilayah (Sertakan nilai kolom 'tipe')
        Wilayah::create([
            'nama_wilayah' => 'Kecamatan Banjarmasin Utara',
            'tipe'         => 'Kecamatan',
        ]);
        Wilayah::create([
            'nama_wilayah' => 'Kecamatan Banjarmasin Selatan',
            'tipe'         => 'Kecamatan',
        ]);
        Wilayah::create([
            'nama_wilayah' => 'Kecamatan Banjarmasin Timur',
            'tipe'         => 'Kecamatan',
        ]);
        Wilayah::create([
            'nama_wilayah' => 'Kecamatan Banjarmasin Tengah',
            'tipe'         => 'Kecamatan',
        ]);
    }
}