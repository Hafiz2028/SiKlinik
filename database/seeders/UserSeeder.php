<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil semua role yang ada
        $adminRole = Role::where('slug', 'admin')->first();
        $petugasRole = Role::where('slug', 'petugas-pendaftaran')->first();
        $dokterRole = Role::where('slug', 'dokter')->first();
        $kasirRole = Role::where('slug', 'kasir')->first();

        // 2. Buat user untuk setiap role dengan alur yang benar

        // =========================================================================
        // User Admin
        // =========================================================================
        // Buat User terlebih dahulu
        $adminUser = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
        ]);

        // Kemudian buat data Pegawai yang terhubung dengan User menggunakan relasi
        $adminUser->pegawai()->create([
            'nama_lengkap' => $adminUser->name,
            'nik' => '1111111111111111',
            'alamat' => 'Kantor Pusat',
            'no_telepon' => '081234567890',
            'jabatan' => 'System Administrator',
        ]);

        // Terakhir, lampirkan role ke user
        $adminUser->roles()->attach($adminRole);


        // =========================================================================
        // User Petugas Pendaftaran
        // =========================================================================
        $petugasUser = User::create([
            'name' => 'Siti Pendaftar',
            'email' => 'petugas@mail.com',
            'password' => Hash::make('admin'),
        ]);

        $petugasUser->pegawai()->create([
            'nama_lengkap' => $petugasUser->name,
            'nik' => '2222222222222222',
            'alamat' => 'Jl. Pendaftaran No. 1',
            'no_telepon' => '081234567891',
            'jabatan' => 'Staf Pendaftaran',
        ]);

        $petugasUser->roles()->attach($petugasRole);


        // =========================================================================
        // User Dokter
        // =========================================================================
        $dokterUser = User::create([
            'name' => 'Dokter Ana',
            'email' => 'dokter@mail.com',
            'password' => Hash::make('admin'),
        ]);

        $dokterUser->pegawai()->create([
            'nama_lengkap' => $dokterUser->name,
            'nik' => '3333333333333333',
            'alamat' => 'Jl. Sehat No. 2',
            'no_telepon' => '081234567892',
            'jabatan' => 'Dokter Umum',
        ]);

        $dokterUser->roles()->attach($dokterRole);


        // =========================================================================
        // User Kasir
        // =========================================================================
        $kasirUser = User::create([
            'name' => 'Kasir Budi',
            'email' => 'kasir@mail.com',
            'password' => Hash::make('admin'),
        ]);

        $kasirUser->pegawai()->create([
            'nama_lengkap' => $kasirUser->name,
            'nik' => '4444444444444444',
            'alamat' => 'Jl. Keuangan No. 3',
            'no_telepon' => '081234567893',
            'jabatan' => 'Staf Keuangan',
        ]);

        $kasirUser->roles()->attach($kasirRole);
    }
}
