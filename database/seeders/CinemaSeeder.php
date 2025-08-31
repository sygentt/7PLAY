<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Cinema;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get cities for reference
        $jakarta = City::where('code', 'JKT')->first();
        $bandung = City::where('code', 'BDG')->first();
        $surabaya = City::where('code', 'SBY')->first();
        $medan = City::where('code', 'MDN')->first();
        $makassar = City::where('code', 'MKS')->first();
        $denpasar = City::where('code', 'DPS')->first();

        if (!$jakarta || !$bandung || !$surabaya) {
            $this->command->error('Cities must be seeded first! Please run CitySeeder.');
            return;
        }

        $cinemas = [
            // Jakarta
            [
                'city_id' => $jakarta->id,
                'name' => 'Grand Indonesia',
                'brand' => 'XXI',
                'address' => 'Jl. MH. Thamrin No.1, Jakarta 10310',
                'phone' => '021-23580000',
                'latitude' => -6.1951,
                'longitude' => 106.8234,
                'is_active' => true,
            ],
            [
                'city_id' => $jakarta->id,
                'name' => 'Central Park',
                'brand' => 'XXI',
                'address' => 'Jl. Letjen S. Parman, Jakarta Barat 11470',
                'phone' => '021-29217777',
                'latitude' => -6.1761,
                'longitude' => 106.7909,
                'is_active' => true,
            ],
            [
                'city_id' => $jakarta->id,
                'name' => 'Pacific Place',
                'brand' => 'XXI',
                'address' => 'Jl. Jenderal Sudirman Kav 52-53, Jakarta 12190',
                'phone' => '021-51401414',
                'latitude' => -6.2253,
                'longitude' => 106.8097,
                'is_active' => true,
            ],
            [
                'city_id' => $jakarta->id,
                'name' => 'Senayan City',
                'brand' => 'CGV',
                'address' => 'Jl. Asia Afrika No.19, Jakarta 10270',
                'phone' => '021-72770021',
                'latitude' => -6.2253,
                'longitude' => 106.8019,
                'is_active' => true,
            ],
            [
                'city_id' => $jakarta->id,
                'name' => 'Mall Kelapa Gading',
                'brand' => 'CGV',
                'address' => 'Jl. Boulevard Kelapa Gading, Jakarta Utara 14240',
                'phone' => '021-45842100',
                'latitude' => -6.1588,
                'longitude' => 106.9099,
                'is_active' => true,
            ],

            // Bandung
            [
                'city_id' => $bandung->id,
                'name' => 'Paris Van Java',
                'brand' => 'XXI',
                'address' => 'Jl. Sukajadi No.131-139, Bandung 40162',
                'phone' => '022-82061101',
                'latitude' => -6.8951,
                'longitude' => 107.5847,
                'is_active' => true,
            ],
            [
                'city_id' => $bandung->id,
                'name' => 'Bandung Electronic Center',
                'brand' => 'XXI',
                'address' => 'Jl. Purnawarman No.13-15, Bandung 40117',
                'phone' => '022-4230121',
                'latitude' => -6.9174,
                'longitude' => 107.6191,
                'is_active' => true,
            ],
            [
                'city_id' => $bandung->id,
                'name' => 'Trans Studio Mall',
                'brand' => 'CGV',
                'address' => 'Jl. Gatot Subroto No.289, Bandung 40273',
                'phone' => '022-87242345',
                'latitude' => -6.9389,
                'longitude' => 107.6371,
                'is_active' => true,
            ],

            // Surabaya
            [
                'city_id' => $surabaya->id,
                'name' => 'Tunjungan Plaza',
                'brand' => 'XXI',
                'address' => 'Jl. Embong Malang No.15-31, Surabaya 60261',
                'phone' => '031-5311503',
                'latitude' => -7.2634,
                'longitude' => 112.7437,
                'is_active' => true,
            ],
            [
                'city_id' => $surabaya->id,
                'name' => 'Pakuwon Mall',
                'brand' => 'CGV',
                'address' => 'Jl. Puncak Indah Lontar, Surabaya 60216',
                'phone' => '031-99000888',
                'latitude' => -7.3199,
                'longitude' => 112.6777,
                'is_active' => true,
            ],
            [
                'city_id' => $surabaya->id,
                'name' => 'Ciputra World',
                'brand' => 'Cinepolis',
                'address' => 'Jl. Mayjend Sungkono No.89, Surabaya 60224',
                'phone' => '031-99123456',
                'latitude' => -7.2851,
                'longitude' => 112.6796,
                'is_active' => true,
            ],
        ];

        // Add cinemas for other cities if they exist
        if ($medan) {
            $cinemas[] = [
                'city_id' => $medan->id,
                'name' => 'Sun Plaza',
                'brand' => 'XXI',
                'address' => 'Jl. KH. Wahid Hasyim No.8, Medan 20154',
                'phone' => '061-4514242',
                'latitude' => 3.5833,
                'longitude' => 98.6667,
                'is_active' => true,
            ];
        }

        if ($makassar) {
            $cinemas[] = [
                'city_id' => $makassar->id,
                'name' => 'Mall Panakkukang',
                'brand' => 'XXI',
                'address' => 'Jl. Boulevard No.15, Makassar 90231',
                'phone' => '0411-454545',
                'latitude' => -5.1477,
                'longitude' => 119.4327,
                'is_active' => true,
            ];
        }

        if ($denpasar) {
            $cinemas[] = [
                'city_id' => $denpasar->id,
                'name' => 'Beachwalk Shopping Center',
                'brand' => 'XXI',
                'address' => 'Jl. Pantai Kuta, Denpasar 80361',
                'phone' => '0361-8464646',
                'latitude' => -8.7203,
                'longitude' => 115.1686,
                'is_active' => true,
            ];
        }

        foreach ($cinemas as $cinemaData) {
            Cinema::updateOrCreate(
                [
                    'city_id' => $cinemaData['city_id'],
                    'name' => $cinemaData['name'],
                    'brand' => $cinemaData['brand']
                ],
                $cinemaData
            );
        }

        $this->command->info('Sample cinemas created successfully!');
        $this->command->info('Created ' . count($cinemas) . ' cinemas across major cities.');
    }
}
