<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prahari;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        $praharis = Prahari::all();

        if ($praharis->isEmpty()) {
            return;
        }

        foreach ($praharis as $prahari) {
            Wallet::updateOrCreate(
                ['prahari_id' => $prahari->id],
                [
                    'balance' => rand(1000, 10000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
