<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users (excluding admins for customer notifications)
        $customers = User::where('is_admin', false)->get();
        $all_users = User::all();

        if ($customers->isEmpty() || $all_users->isEmpty()) {
            $this->command->warn('⚠️  No users found. Please run UserSeeder first.');
            return;
        }

        $notifications = [];

        // System Notifications (broadcast to all users)
        $system_notifications = [
            [
                'type' => 'system',
                'title' => 'Selamat Datang di 7PLAY!',
                'message' => 'Terima kasih telah bergabung dengan 7PLAY. Nikmati pengalaman menonton film yang luar biasa!',
                'data' => [
                    'audience' => 'all',
                    'batch_key' => 'welcome_' . now()->timestamp,
                    'icon' => 'hand-raised',
                    'action_url' => null,
                ],
                'is_read' => false,
            ],
            [
                'type' => 'system',
                'title' => 'Update Sistem v2.0',
                'message' => 'Kami telah melakukan pembaruan sistem untuk memberikan pengalaman yang lebih baik. Cek fitur-fitur baru kami!',
                'data' => [
                    'audience' => 'all',
                    'batch_key' => 'update_' . now()->timestamp,
                    'icon' => 'sparkles',
                    'action_url' => null,
                ],
                'is_read' => false,
            ],
        ];

        // Create system notifications for all users
        foreach ($all_users as $user) {
            foreach ($system_notifications as $notif) {
                $notifications[] = array_merge($notif, [
                    'user_id' => $user->id,
                    'created_at' => now()->subDays(rand(1, 7)),
                    'updated_at' => now()->subDays(rand(1, 7)),
                ]);
            }
        }

        // Promo Notifications (for customers only)
        $promo_templates = [
            [
                'type' => 'promo',
                'title' => '🎉 Flash Sale Weekend!',
                'message' => 'Diskon hingga 30% untuk semua film di akhir pekan ini. Buruan booking sebelum kehabisan!',
                'data' => [
                    'icon' => 'gift',
                    'action_url' => '/movies',
                    'promo_code' => 'WEEKEND25',
                ],
                'is_read' => false,
            ],
            [
                'type' => 'promo',
                'title' => '🎁 Voucher Spesial Untukmu',
                'message' => 'Kamu mendapatkan voucher diskon Rp 25.000! Gunakan sekarang sebelum expired.',
                'data' => [
                    'icon' => 'ticket',
                    'action_url' => '/vouchers',
                    'promo_code' => 'FLASH25K',
                ],
                'is_read' => false,
            ],
            [
                'type' => 'promo',
                'title' => '🌟 Poin Reward Menanti!',
                'message' => 'Kumpulkan poin dan tukarkan dengan voucher menarik. Semakin banyak nonton, semakin banyak untung!',
                'data' => [
                    'icon' => 'star',
                    'action_url' => '/profile/points',
                    'promo_code' => null,
                ],
                'is_read' => rand(0, 1) === 1,
            ],
        ];

        foreach ($customers->take(30) as $customer) {
            foreach ($promo_templates as $promo) {
                $notifications[] = array_merge($promo, [
                    'user_id' => $customer->id,
                    'created_at' => now()->subDays(rand(1, 14)),
                    'updated_at' => now()->subDays(rand(1, 14)),
                ]);
            }
        }

        // Movie Notifications
        $movie_templates = [
            [
                'type' => 'movie',
                'title' => '🎬 Film Baru Tayang!',
                'message' => 'Film action blockbuster "Guardians of Time" kini sudah tayang. Jangan sampai ketinggalan!',
                'data' => [
                    'icon' => 'film',
                    'action_url' => '/movies/1',
                    'movie_id' => 1,
                ],
                'is_read' => rand(0, 1) === 1,
            ],
            [
                'type' => 'movie',
                'title' => '🍿 Segera Tayang Minggu Depan',
                'message' => 'Film horor terseram tahun ini "Midnight Terror" akan segera tayang minggu depan. Pre-order sekarang!',
                'data' => [
                    'icon' => 'film',
                    'action_url' => '/movies/2',
                    'movie_id' => 2,
                ],
                'is_read' => false,
            ],
            [
                'type' => 'movie',
                'title' => '💖 Film Romantis Pilihan Editor',
                'message' => '"Love in the Rain" mendapatkan rating tinggi! Film romantis yang wajib ditonton bersama pasangan.',
                'data' => [
                    'icon' => 'heart',
                    'action_url' => '/movies/3',
                    'movie_id' => 3,
                ],
                'is_read' => rand(0, 1) === 1,
            ],
        ];

        foreach ($customers->take(25) as $customer) {
            $selected_movies = collect($movie_templates)->random(rand(1, 2));
            foreach ($selected_movies as $movie) {
                $notifications[] = array_merge($movie, [
                    'user_id' => $customer->id,
                    'created_at' => now()->subDays(rand(1, 10)),
                    'updated_at' => now()->subDays(rand(1, 10)),
                ]);
            }
        }

        // Order Notifications
        $order_templates = [
            [
                'type' => 'order',
                'title' => '✅ Pemesanan Berhasil!',
                'message' => 'Yeay! Tiketmu sudah terbooking. Jangan lupa datang 15 menit sebelum showtime ya.',
                'data' => [
                    'icon' => 'check-circle',
                    'action_url' => '/profile/orders',
                    'order_number' => '7PLAY' . now()->format('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6)),
                ],
                'is_read' => rand(0, 1) === 1,
            ],
            [
                'type' => 'order',
                'title' => '🎟️ E-Ticket Kamu Siap!',
                'message' => 'E-ticket sudah tersedia. Download sekarang dan tunjukkan di loket bioskop.',
                'data' => [
                    'icon' => 'ticket',
                    'action_url' => '/profile/orders/1',
                    'order_number' => '7PLAY' . now()->format('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6)),
                ],
                'is_read' => false,
            ],
            [
                'type' => 'order',
                'title' => '⏰ Reminder: Film Dimulai 2 Jam Lagi',
                'message' => 'Jangan lupa! Film yang kamu booking akan dimulai 2 jam lagi. Kami tunggu kedatanganmu!',
                'data' => [
                    'icon' => 'clock',
                    'action_url' => '/profile/orders/1',
                    'order_number' => '7PLAY' . now()->format('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6)),
                ],
                'is_read' => false,
            ],
            [
                'type' => 'order',
                'title' => '🎉 Poin Sudah Masuk!',
                'message' => 'Selamat! Kamu mendapatkan 100 poin dari pembelian terakhir. Tukar dengan voucher menarik!',
                'data' => [
                    'icon' => 'star',
                    'action_url' => '/profile/points',
                    'points_earned' => 100,
                ],
                'is_read' => rand(0, 1) === 1,
            ],
        ];

        foreach ($customers->take(20) as $customer) {
            $selected_orders = collect($order_templates)->random(rand(1, 3));
            foreach ($selected_orders as $order) {
                $notifications[] = array_merge($order, [
                    'user_id' => $customer->id,
                    'created_at' => now()->subDays(rand(0, 5)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ]);
            }
        }

        // Insert all notifications using create() to properly cast JSON fields
        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        $this->command->info('✅ ' . count($notifications) . ' notifications created successfully!');
    }
}

