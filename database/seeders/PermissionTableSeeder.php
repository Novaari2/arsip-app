<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user',
            'user-add',
            'user-store',
            'user-edit',
            'user-reset-password',
            'user-delete',
            'role',
            'role-create',
            'role-store',
            'role-edit',
            'role-update',
            'role-delete',
            'pejabat_lelang',
            'pejabat_lelang-create',
            'pejabat_lelang-store',
            'pejabat_lelang-edit',
            'pejabat_lelang-update',
            'pejabat_lelang-destroy',
            'kategori_pemohon',
            'kategori_pemohon-create',
            'kategori_pemohon-store',
            'kategori_pemohon-edit',
            'kategori_pemohon-update',
            'kategori_pemohon-destroy',
            'jenis_lelang',
            'jenis_lelang-create',
            'jenis_lelang-store',
            'jenis_lelang-edit',
            'jenis_lelang-update',
            'jenis_lelang-destroy',
            'risalah_lelang',
            'risalah_lelang-add',
            'risalah_lelang-create',
            'rak_gudang',
            'rak_gudang-create',
            'rak_gudang-store',
            'rak_gudang-edit',
            'rak_gudang-update',
            'rak_gudang-destroy',
            'rak_detail',
            'rak_detail-create',
            'rak_detail-store',
            'rak_detail-edit',
            'rak_detail-update',
            'rak_detail-destroy'
        ];
        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }
    }
}
