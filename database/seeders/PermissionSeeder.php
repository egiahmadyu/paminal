<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            'dashboard', 'data-pelanggar', 'input-data', 'anggota', 'tambah-bag_detasemen', 'list-bag_den', 'list-unit', 'import-data', 'view-diterima', 'edit-diterima', 'view-pulbaket', 'edit-pulbaket', 'view-gelar_perkara', 'edit-gelar_perkara', 'view-limpah_biro', 'edit-limpah_biro', 'infosus-li'
        ];

        foreach ($permission as $key => $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
