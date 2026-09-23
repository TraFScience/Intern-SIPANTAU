<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBencana;
use App\Models\Wilayah;
use App\Models\WilayahRawan;
use App\Models\KejadianBencana;
use App\Models\User;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jenis Bencana
        $jenisBencanaList = [
            ['nama_jenis' => 'Banjir', 'deskripsi' => 'Bencana genangan air skala besar'],
            ['nama_jenis' => 'Tanah Longsor', 'deskripsi' => 'Pergerakan tanah/batuan'],
            ['nama_jenis' => 'Puting Beliung', 'deskripsi' => 'Angin kencang berputar'],
            ['nama_jenis' => 'Kebakaran Hutan', 'deskripsi' => 'Kebakaran lahan dan hutan'],
        ];

        foreach ($jenisBencanaList as $jenis) {
            JenisBencana::firstOrCreate(
                ['nama_jenis' => $jenis['nama_jenis']],
                ['deskripsi' => $jenis['deskripsi']]
            );
        }

        // 2. Wilayah
        $wilayahList = [
            ['nama_wilayah' => 'Kabupaten Banjar', 'tipe' => 'Kabupaten', 'latitude' => -3.40813134, 'longitude' => 114.84854166],
            ['nama_wilayah' => 'Kota Banjarmasin', 'tipe' => 'Kota', 'latitude' => -3.3167, 'longitude' => 114.5901],
            ['nama_wilayah' => 'Kota Banjarbaru', 'tipe' => 'Kota', 'latitude' => -3.457242, 'longitude' => 114.810318],
        ];

        foreach ($wilayahList as $wilayah) {
            Wilayah::firstOrCreate(
                ['nama_wilayah' => $wilayah['nama_wilayah']],
                [
                    'tipe'      => $wilayah['tipe'],
                    'latitude'  => $wilayah['latitude'],
                    'longitude' => $wilayah['longitude'],
                ]
            );
        }

        // 3. Wilayah Rawan
        $wilayahUtara = Wilayah::where('nama_wilayah', 'Kecamatan Banjarmasin Utara')->first();
        $wilayahSelatan = Wilayah::where('nama_wilayah', 'Kecamatan Banjarmasin Selatan')->first();
        $wilayahTimur = Wilayah::where('nama_wilayah', 'Kecamatan Banjarmasin Timur')->first();
        $wilayahTengah = Wilayah::where('nama_wilayah', 'Kecamatan Banjarmasin Tengah')->first();

        $banjir = JenisBencana::where('nama_jenis', 'Banjir')->first();
        $longsor = JenisBencana::where('nama_jenis', 'Tanah Longsor')->first();
        $angin = JenisBencana::where('nama_jenis', 'Badai Angin')->first();
        $karhutla = JenisBencana::where('nama_jenis', 'Karhutla')->first();

       if ($wilayahUtara && $banjir) {
    WilayahRawan::updateOrCreate(
        [
            'wilayah_id' => $wilayahUtara->id,
            'jenis_bencana_id' => $banjir->id,
        ],
        [
            'tingkat_kerawanan' => 'Tinggi',
            'keterangan' => 'Rawan genangan banjir pasang surut air sungai',
            'polygon' => [
                [-3.2870, 114.6020],
                [-3.2980, 114.5900],
                [-3.2920, 114.5780],
                [-3.2750, 114.5750],
                [-3.2870, 114.6020],
            ],
        ]
    );
}

if ($wilayahSelatan && $longsor) {
    WilayahRawan::updateOrCreate(
        [
            'wilayah_id' => $wilayahSelatan->id,
            'jenis_bencana_id' => $longsor->id,
        ],
        [
            'tingkat_kerawanan' => 'Sedang',
            'keterangan' => 'Contoh zona rawan tanah longsor',
            'polygon' => [
                [-3.3450, 114.5800],
                [-3.3380, 114.5900],
                [-3.3480, 114.6020],
                [-3.3620, 114.6000],
                [-3.3700, 114.5880],
                [-3.3600, 114.5780],
                [-3.3450, 114.5800],
            ],
        ]
    );
}

if ($wilayahTimur && $angin) {
    WilayahRawan::updateOrCreate(
        [
            'wilayah_id' => $wilayahTimur->id,
            'jenis_bencana_id' => $angin->id,
        ],
        [
            'tingkat_kerawanan' => 'Sedang',
            'keterangan' => 'Contoh zona rawan angin kencang',
            'polygon' => [
                [-3.3150, 114.6050],
                [-3.3200, 114.6180],
                [-3.3320, 114.6250],
                [-3.3420, 114.6150],
                [-3.3370, 114.6020],
                [-3.3250, 114.5980],
                [-3.3150, 114.6050],
            ],
        ]
    );
}

if ($wilayahTengah && $karhutla) {
    WilayahRawan::updateOrCreate(
        [
            'wilayah_id' => $wilayahTengah->id,
            'jenis_bencana_id' => $karhutla->id,
        ],
        [
            'tingkat_kerawanan' => 'Tinggi',
            'keterangan' => 'Contoh zona rawan kebakaran lahan',
            'polygon' => [
                [-3.3050, 114.5820],
                [-3.2980, 114.5920],
                [-3.3070, 114.6020],
                [-3.3220, 114.6010],
                [-3.3280, 114.5890],
                [-3.3180, 114.5800],
                [-3.3050, 114.5820],
            ],
        ]
    );
}
        // 4. Kejadian Bencana
        $user = User::first();

        if ($user && $wilayahUtara && $banjir) {
            KejadianBencana::firstOrCreate(
                ['judul' => 'Banjir Rob Sungai Martapura'],
                [
                    'user_id'           => $user->id,
                    'verified_id'       => $user->id,
                    'jenis_bencana_id' => $banjir->id,
                    'wilayah_id'        => $wilayahUtara->id,
                    'deskripsi'         => 'Air sungai meluap menggenangi pemukiman warga sekitar 30cm.',
                    'tanggal_kejadian'  => now(),
                    'gambar'            => null,
                    'status_verifikasi' => 'terverifikasi',
                ]
            );
        }
    }
}