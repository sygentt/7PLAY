<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Jawa
            ['name' => 'Jakarta', 'province' => 'DKI Jakarta', 'code' => 'JKT', 'is_active' => true],
            ['name' => 'Bogor', 'province' => 'Jawa Barat', 'code' => 'BGR', 'is_active' => true],
            ['name' => 'Depok', 'province' => 'Jawa Barat', 'code' => 'DPK', 'is_active' => true],
            ['name' => 'Tangerang', 'province' => 'Banten', 'code' => 'TNG', 'is_active' => true],
            ['name' => 'Bekasi', 'province' => 'Jawa Barat', 'code' => 'BKS', 'is_active' => true],
            ['name' => 'Bandung', 'province' => 'Jawa Barat', 'code' => 'BDG', 'is_active' => true],
            ['name' => 'Semarang', 'province' => 'Jawa Tengah', 'code' => 'SMG', 'is_active' => true],
            ['name' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'code' => 'YGY', 'is_active' => true],
            ['name' => 'Surakarta', 'province' => 'Jawa Tengah', 'code' => 'SLO', 'is_active' => true],
            ['name' => 'Malang', 'province' => 'Jawa Timur', 'code' => 'MLG', 'is_active' => true],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur', 'code' => 'SBY', 'is_active' => true],
            
            // Sumatera
            ['name' => 'Medan', 'province' => 'Sumatera Utara', 'code' => 'MDN', 'is_active' => true],
            ['name' => 'Pekanbaru', 'province' => 'Riau', 'code' => 'PKU', 'is_active' => true],
            ['name' => 'Padang', 'province' => 'Sumatera Barat', 'code' => 'PDG', 'is_active' => true],
            ['name' => 'Palembang', 'province' => 'Sumatera Selatan', 'code' => 'PLG', 'is_active' => true],
            ['name' => 'Bandar Lampung', 'province' => 'Lampung', 'code' => 'BDL', 'is_active' => true],
            
            // Kalimantan
            ['name' => 'Pontianak', 'province' => 'Kalimantan Barat', 'code' => 'PTK', 'is_active' => true],
            ['name' => 'Banjarmasin', 'province' => 'Kalimantan Selatan', 'code' => 'BJM', 'is_active' => true],
            ['name' => 'Samarinda', 'province' => 'Kalimantan Timur', 'code' => 'SMD', 'is_active' => true],
            ['name' => 'Balikpapan', 'province' => 'Kalimantan Timur', 'code' => 'BPN', 'is_active' => true],
            
            // Sulawesi
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan', 'code' => 'MKS', 'is_active' => true],
            ['name' => 'Manado', 'province' => 'Sulawesi Utara', 'code' => 'MDO', 'is_active' => true],
            ['name' => 'Kendari', 'province' => 'Sulawesi Tenggara', 'code' => 'KDI', 'is_active' => true],
            ['name' => 'Palu', 'province' => 'Sulawesi Tengah', 'code' => 'PLU', 'is_active' => true],
            
            // Bali & Nusa Tenggara
            ['name' => 'Denpasar', 'province' => 'Bali', 'code' => 'DPS', 'is_active' => true],
            ['name' => 'Mataram', 'province' => 'Nusa Tenggara Barat', 'code' => 'MTR', 'is_active' => true],
            ['name' => 'Kupang', 'province' => 'Nusa Tenggara Timur', 'code' => 'KPG', 'is_active' => true],
            
            // Papua & Maluku
            ['name' => 'Jayapura', 'province' => 'Papua', 'code' => 'JYP', 'is_active' => true],
            ['name' => 'Ambon', 'province' => 'Maluku', 'code' => 'AMQ', 'is_active' => true],
        ];

        foreach ($cities as $cityData) {
            City::updateOrCreate(
                ['code' => $cityData['code']],
                $cityData
            );
        }

        $this->command->info('Sample cities created successfully!');
        $this->command->info('Created ' . count($cities) . ' cities across Indonesia.');
    }
}
