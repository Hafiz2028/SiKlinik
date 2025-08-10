<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TIndakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum diisi
        DB::table('tindakans')->truncate();

        $this->command->info('Memasukkan data awal untuk Tindakan...');

        DB::table('tindakans')->insert([
            [
                'nama_tindakan' => 'Konsultasi Dokter Umum',
                'deskripsi' => 'Pemeriksaan dan konsultasi awal oleh dokter umum.',
                'harga' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tindakan' => 'Cek Gula Darah Sewaktu',
                'deskripsi' => 'Pemeriksaan kadar gula darah tanpa perlu puasa.',
                'harga' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tindakan' => 'Cek Asam Urat',
                'deskripsi' => 'Pemeriksaan kadar asam urat dalam darah.',
                'harga' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tindakan' => 'Perawatan Luka Ringan',
                'deskripsi' => 'Membersihkan dan menutup luka lecet atau sayatan kecil.',
                'harga' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tindakan' => 'Nebulizer (Uap)',
                'deskripsi' => 'Terapi uap untuk melegakan pernapasan.',
                'harga' => 60000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Data Tindakan berhasil dimasukkan.');
    }
}
