<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            // Percentage Discount Vouchers
            [
                'name' => 'FIRSTWATCH',
                'description' => 'Diskon 20% untuk pembelian pertama kamu! Nikmati film favoritmu dengan harga spesial.',
                'type' => 'percentage',
                'value' => 20.00,
                'min_purchase' => 50000.00,
                'max_discount' => 50000.00,
                'points_required' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'name' => 'WEEKEND25',
                'description' => 'Diskon 25% untuk menonton di akhir pekan! Berlaku Sabtu dan Minggu.',
                'type' => 'percentage',
                'value' => 25.00,
                'min_purchase' => 100000.00,
                'max_discount' => 75000.00,
                'points_required' => 500,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'name' => 'BIGSCREEN30',
                'description' => 'Hemat 30% untuk pembelian 3 tiket atau lebih. Ajak teman dan keluarga!',
                'type' => 'percentage',
                'value' => 30.00,
                'min_purchase' => 150000.00,
                'max_discount' => 100000.00,
                'points_required' => 1000,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
            ],

            // Fixed Amount Discount Vouchers
            [
                'name' => 'SAVE10K',
                'description' => 'Potongan langsung Rp 10.000 untuk semua film. Berlaku untuk pembelian minimal Rp 50.000.',
                'type' => 'fixed',
                'value' => 10000.00,
                'min_purchase' => 50000.00,
                'max_discount' => 10000.00,
                'points_required' => 250,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(1),
                'is_active' => true,
            ],
            [
                'name' => 'FLASH25K',
                'description' => 'Flash Sale! Potongan Rp 25.000 untuk pembelian hari ini. Buruan sebelum kehabisan!',
                'type' => 'fixed',
                'value' => 25000.00,
                'min_purchase' => 100000.00,
                'max_discount' => 25000.00,
                'points_required' => 750,
                'valid_from' => now(),
                'valid_until' => now()->addDays(7),
                'is_active' => true,
            ],
            [
                'name' => 'MEGA50K',
                'description' => 'Mega Diskon Rp 50.000! Untuk pembelian minimal Rp 200.000. Limited time only!',
                'type' => 'fixed',
                'value' => 50000.00,
                'min_purchase' => 200000.00,
                'max_discount' => 50000.00,
                'points_required' => 1500,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(1),
                'is_active' => true,
            ],

            // Special Promo Vouchers
            [
                'name' => 'MIDNIGHT15',
                'description' => 'Diskon 15% untuk midnight screening! Untuk yang suka nonton tengah malam.',
                'type' => 'percentage',
                'value' => 15.00,
                'min_purchase' => 40000.00,
                'max_discount' => 30000.00,
                'points_required' => 300,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'name' => 'BIRTHDAY50',
                'description' => 'Selamat ulang tahun! Nikmati diskon spesial 50% di bulan ulang tahunmu.',
                'type' => 'percentage',
                'value' => 50.00,
                'min_purchase' => 75000.00,
                'max_discount' => 100000.00,
                'points_required' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
                'is_active' => true,
            ],
            [
                'name' => 'STUDENT20',
                'description' => 'Diskon 20% khusus pelajar dan mahasiswa. Tunjukkan kartu pelajar/mahasiswamu.',
                'type' => 'percentage',
                'value' => 20.00,
                'min_purchase' => 50000.00,
                'max_discount' => 40000.00,
                'points_required' => 200,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'is_active' => true,
            ],

            // Loyalty Rewards Vouchers
            [
                'name' => 'LOYAL35K',
                'description' => 'Terima kasih atas loyalitasmu! Potongan Rp 35.000 untuk member setia 7PLAY.',
                'type' => 'fixed',
                'value' => 35000.00,
                'min_purchase' => 120000.00,
                'max_discount' => 35000.00,
                'points_required' => 2000,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'name' => 'VIP40',
                'description' => 'Voucher VIP eksklusif! Diskon 40% untuk member premium dengan poin tinggi.',
                'type' => 'percentage',
                'value' => 40.00,
                'min_purchase' => 200000.00,
                'max_discount' => 150000.00,
                'points_required' => 3000,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'name' => 'PLATINUM100K',
                'description' => 'Platinum Member Only! Potongan super besar Rp 100.000 untuk transaksi besar.',
                'type' => 'fixed',
                'value' => 100000.00,
                'min_purchase' => 300000.00,
                'max_discount' => 100000.00,
                'points_required' => 5000,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(1),
                'is_active' => true,
            ],

            // Expired/Inactive Vouchers (for testing)
            [
                'name' => 'EXPIRED10',
                'description' => 'Voucher yang sudah kedaluwarsa. Tidak dapat digunakan lagi.',
                'type' => 'percentage',
                'value' => 10.00,
                'min_purchase' => 50000.00,
                'max_discount' => 20000.00,
                'points_required' => 0,
                'valid_from' => now()->subMonths(2),
                'valid_until' => now()->subMonth(),
                'is_active' => false,
            ],
            [
                'name' => 'INACTIVE15',
                'description' => 'Voucher yang tidak aktif. Sedang dalam maintenance.',
                'type' => 'fixed',
                'value' => 15000.00,
                'min_purchase' => 60000.00,
                'max_discount' => 15000.00,
                'points_required' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonth(),
                'is_active' => false,
            ],
        ];

        foreach ($vouchers as $voucher_data) {
            Voucher::create($voucher_data);
        }

        $this->command->info('✅ ' . count($vouchers) . ' vouchers created successfully!');
    }
}

