<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'kelola-pengguna',
            'kelola-berita',
            'kelola-bencana',
            'verifikasi-bencana',
            'lapor-bencana',
            'kelola-wilayah',
            'kelola-jenis-bencana',
            'kelola-wilayah-rawan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions);

        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugas->syncPermissions([
            'kelola-bencana',
            'verifikasi-bencana',
            'lapor-bencana',
            'kelola-berita',
            'kelola-wilayah-rawan',
        ]);

        Role::firstOrCreate(['name' => 'masyarakat', 'guard_name' => 'web'])
            ->syncPermissions(['lapor-bencana']);
    }
}
