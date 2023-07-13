<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Process;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Permission::create(['name' => 'manage-auth']);
        $adminRole = Role::create(['name' => 'admin']);
        $permission = Permission::where('name', 'manage-auth')->first();
        $adminRole->givePermissionTo($permission);
        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);

        $user->assignRole($adminRole);
        $adminRole = Role::create(['name' => 'operator']);
        $user = User::create([
            'name' => 'egi',
            'username' => 'egiahmadyu',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole($adminRole);

        Process::create([
            'name' => 'Diterima'
        ]);

        Process::create([
            'name' => 'Disposisi'
        ]);

        Process::create([
            'name' => 'Limpah'
        ]);

        Process::create([
            'name' => 'Pulbaket'
        ]);

        Process::create([
            'name' => 'Gelar Penyidikan'
        ]);

        Process::create([
            'name' => 'Nota Dinas Hasil Gelar'
        ]);

        $this->call([
            AgamaSeeder::class,
            JenisKelaminSeed::class,
            JenisIdentitasSeeder::class,
            DataPelanggarSeed::class,
            PoldaSeed::class,
            PangkatSeeder::class,
            WujudPerbuatanSeeder::class,
            DatasemenSeeder::class,
            UnitSeeder::class,
            DataAnggotaSeeder::class,
          ]);

        // Process::create([
        //     'name' => 'Diterima'
        // ]);
    }
}