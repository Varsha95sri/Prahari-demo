<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Prahari;
use App\Models\Cases;
use Illuminate\Support\Str;

class CasesSeeder extends Seeder
{
    public function run(): void
    {
        $praharis = Prahari::all();

        if ($praharis->isEmpty()) {
            return;
        }

        foreach ($praharis as $prahari) {
            Cases::create([
                'case_id' => 'CAS' . strtoupper(Str::random(6)),
                'prahari_id' => $prahari->id,
                'type' => 'Traffic Violation',
                'location' => 'Location ' . rand(1, 100),
                'description' => 'Dummy case description for ' . $prahari->name,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Cases::create([
                'case_id' => 'CAS' . strtoupper(Str::random(6)),
                'prahari_id' => $prahari->id,
                'type' => 'Illegal Parking',
                'location' => 'Location ' . rand(101, 200),
                'description' => 'Another dummy case for ' . $prahari->name,
                'status' => 'closed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
