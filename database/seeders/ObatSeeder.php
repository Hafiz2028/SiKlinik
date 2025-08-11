<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum diisi
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel (anak dulu, baru induk)
        DB::table('kunjungan_obat')->truncate();
        DB::table('obats')->truncate();

        $this->command->info('Memasukkan data awal untuk Obat...');

        DB::table('obats')->insert([
            [
                'nama_obat' => 'Paracetamol 500mg',
                'satuan' => 'Tablet',
                'stok' => 100,
                'harga' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'satuan' => 'Kapsul',
                'stok' => 80,
                'harga' => 2500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'OBH Combi Batuk Flu',
                'satuan' => 'Botol 100ml',
                'stok' => 50,
                'harga' => 18000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Betadine Antiseptic Solution',
                'satuan' => 'Botol 60ml',
                'stok' => 40,
                'harga' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Asam Mefenamat 500mg',
                'satuan' => 'Tablet',
                'stok' => 120,
                'harga' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Data Obat berhasil dimasukkan.');
    }
}
