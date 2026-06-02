<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cases;
use App\Models\Challan;
use Illuminate\Support\Str;

class ChallanSeeder extends Seeder
{
    public function run(): void
    {
        $cases = Cases::all();

        if ($cases->isEmpty()) {
            return;
        }

        foreach ($cases as $case) {
            Challan::create([
                'challan_id' => 'CHL' . strtoupper(Str::random(6)),
                'case_id' => $case->id,
                'prahari_id' => $case->prahari_id,
                'amount' => rand(500, 2000),
                'status' => rand(0, 1) ? 'paid' : 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
