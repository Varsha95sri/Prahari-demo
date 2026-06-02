<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prahari;
use App\Models\Withdrawal;

class WithdrawalSeeder extends Seeder
{
    public function run(): void
    {
        $praharis = Prahari::all();

        if ($praharis->isEmpty()) {
            return;
        }

        foreach ($praharis as $prahari) {
            Withdrawal::create([
                'prahari_id' => $prahari->id,
                'amount' => rand(500, 2000),
                'bank_account' => $prahari->bank_account ?? '1234567890',
                'ifsc' => 'SBIN0001234',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Withdrawal::create([
                'prahari_id' => $prahari->id,
                'amount' => rand(500, 2000),
                'bank_account' => $prahari->bank_account ?? '1234567890',
                'ifsc' => 'SBIN0001234',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
