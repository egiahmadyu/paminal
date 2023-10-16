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
            'tambah-bag_detasemen', 'list-unit', 'view-diterima', 'edit-diterima', 'view-pulbaket', 'edit-pulbaket', 'view-gelar_perkara', 'edit-gelar_perkara', 'view-limpah_biro', 'edit-limpah_biro',
        ];

        foreach ($permission as $key => $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
