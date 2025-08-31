<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            [
                'email' => 'admin@7play.com'
            ],
            [
                'name' => 'Admin 7PLAY',
                'email' => 'admin@7play.com',
                'password' => Hash::make('admin123'),
                'phone' => '08123456789',
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'is_active' => true,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample admin users for testing
        User::updateOrCreate(
            [
                'email' => 'superadmin@7play.com'
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@7play.com', 
                'password' => Hash::make('superadmin123'),
                'phone' => '08123456788',
                'birth_date' => '1985-01-01',
                'gender' => 'female',
                'is_active' => true,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Email: admin@7play.com | Password: admin123');
        $this->command->info('Email: superadmin@7play.com | Password: superadmin123');
    }
}
