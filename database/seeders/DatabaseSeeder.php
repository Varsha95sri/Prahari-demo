<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@prahari.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // Seed Prahari data
        $this->call([
            PrahariSeeder::class,
            CasesSeeder::class,
            ChallanSeeder::class,
            WalletSeeder::class,
            TransactionSeeder::class,
            WithdrawalSeeder::class,
        ]);
    }
}

