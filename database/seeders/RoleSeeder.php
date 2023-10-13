<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            'pimpinan', // KARO DAN SESRO
            'pimpinan_pelaksana', // KADEN DAN KABAG
            'min', // PENOMORAN SURAT DAN PENOMORAN AGENDA
            'unit' // UNIT
        ];

        foreach ($role as $key => $value) {
            Role::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
