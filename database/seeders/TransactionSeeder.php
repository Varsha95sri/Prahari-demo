<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challan;
use App\Models\Transaction;
use App\Models\Prahari;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $challans = Challan::where('status', 'paid')->get();

        if ($challans->isEmpty()) {
            return;
        }

        foreach ($challans as $challan) {
            Transaction::create([
                'prahari_id' => $challan->prahari_id,
                'challan_id' => $challan->id,
                'type' => 'credit',
                'amount' => $challan->amount * 0.10, // Assuming 10% commission
                'description' => 'Commission for Challan ' . $challan->challan_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
