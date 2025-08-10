<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Base URL of the API
        $baseUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api/';

        // Disable foreign key checks to truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kecamatans')->truncate();
        DB::table('kabupatens')->truncate();
        DB::table('provinsis')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Memulai pengambilan data wilayah dari API...');

        // 1. Fetch and insert Provinces
        $provincesResponse = Http::get($baseUrl . 'provinces.json');
        if ($provincesResponse->successful()) {
            $provinces = $provincesResponse->json();
            $provinsiData = [];
            foreach ($provinces as $province) {
                $provinsiData[] = [
                    'id' => $province['id'],
                    'nama' => $province['name'],
                ];
            }
            DB::table('provinsis')->insert($provinsiData);
            $this->command->info(count($provinsiData) . ' Provinsi berhasil diimpor.');
        } else {
            $this->command->error('Gagal mengambil data provinsi.');
            return;
        }

        // 2. Fetch and insert Regencies (Kabupaten) for each Province
        $allRegencies = [];
        $provinceIds = array_column($provinsiData, 'id');
        $progressBar = $this->command->getOutput()->createProgressBar(count($provinceIds));
        $progressBar->start();
        $this->command->info("\nMengambil data Kabupaten/Kota...");

        foreach ($provinceIds as $provinceId) {
            $regenciesResponse = Http::get($baseUrl . 'regencies/' . $provinceId . '.json');
            if ($regenciesResponse->successful()) {
                $regencies = $regenciesResponse->json();
                foreach ($regencies as $regency) {
                    $allRegencies[] = [
                        'id' => $regency['id'],
                        'provinsi_id' => $regency['province_id'],
                        'nama' => $regency['name'],
                    ];
                }
            }
            $progressBar->advance();
        }
        DB::table('kabupatens')->insert($allRegencies);
        $progressBar->finish();
        $this->command->info("\n" . count($allRegencies) . ' Kabupaten/Kota berhasil diimpor.');

        // 3. Fetch and insert Districts (Kecamatan) for each Regency
        $allDistricts = [];
        $regencyIds = array_column($allRegencies, 'id');
        $progressBar = $this->command->getOutput()->createProgressBar(count($regencyIds));
        $progressBar->start();
        $this->command->info("\nMengambil data Kecamatan (ini mungkin memakan waktu beberapa menit)...");

        foreach ($regencyIds as $regencyId) {
            $districtsResponse = Http::get($baseUrl . 'districts/' . $regencyId . '.json');
            if ($districtsResponse->successful()) {
                $districts = $districtsResponse->json();
                foreach ($districts as $district) {
                    $allDistricts[] = [
                        'id' => $district['id'],
                        'kabupaten_id' => $district['regency_id'],
                        'nama' => $district['name'],
                    ];
                }
            }
            $progressBar->advance();
        }
        DB::table('kecamatans')->insert($allDistricts);
        $progressBar->finish();
        $this->command->info("\n" . count($allDistricts) . ' Kecamatan berhasil diimpor.');

        $this->command->info('Proses seeding data wilayah selesai.');
    }
}
