<?php

namespace Database\Seeders;

use App\Models\JenisKunjungan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema;

class TIndakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('kunjungan_tindakan')->truncate();
        DB::table('tindakans')->truncate();
        DB::table('jenis_kunjungans')->truncate();

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

        JenisKunjungan::create(['nama' => 'Pemeriksaan Umum']);
        JenisKunjungan::create(['nama' => 'Konsultasi']);
        JenisKunjungan::create(['nama' => 'Kontrol']);
        JenisKunjungan::create(['nama' => 'Gawat Darurat']);
    }
}
