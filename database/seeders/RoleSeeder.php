<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'Petugas Pendaftaran', 'slug' => 'petugas-pendaftaran']);
        Role::create(['name' => 'Dokter', 'slug' => 'dokter']);
        Role::create(['name' => 'Kasir', 'slug' => 'kasir']);
    }
}
