<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrahariSeeder extends Seeder
{
    public function run(): void
    {
        $praharis = [

            [
                'name' => 'Rahul Singh',
                'email' => 'rahul@example.com',
                'phone' => '9876543210',
                'aadhaar_number' => '123412341234',
                'bank_account' => '1234567890',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'prahari_id' => 'PRH001',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Aman Verma',
                'email' => 'aman@example.com',
                'phone' => '9876543211',
                'aadhaar_number' => '234523452345',
                'bank_account' => '1234567891',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'prahari_id' => 'PRH002',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Priya Sharma',
                'email' => 'priya@example.com',
                'phone' => '9876543212',
                'aadhaar_number' => '345634563456',
                'bank_account' => '1234567892',
                'status' => 'inactive',
                'password' => Hash::make('password123'),
                'prahari_id' => 'PRH003',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Neha Gupta',
                'email' => 'neha@example.com',
                'phone' => '9876543213',
                'aadhaar_number' => '456745674567',
                'bank_account' => '1234567893',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'prahari_id' => 'PRH004',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Arjun Mishra',
                'email' => 'arjun@example.com',
                'phone' => '9876543214',
                'aadhaar_number' => '567856785678',
                'bank_account' => '1234567894',
                'status' => 'inactive',
                'password' => Hash::make('password123'),
                'prahari_id' => 'PRH005',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        foreach ($praharis as $prahari) {
            DB::table('praharis')->updateOrInsert(
                ['email' => $prahari['email']],
                $prahari
            );
        }
    }
}
