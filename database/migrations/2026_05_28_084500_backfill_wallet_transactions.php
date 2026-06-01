<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('challans')
            ->where('status', 'paid')
            ->orderBy('id')
            ->get()
            ->each(function ($challan) {
                $exists = DB::table('transactions')
                    ->where('challan_id', $challan->id)
                    ->where('type', 'credit')
                    ->exists();

                if ($exists) {
                    return;
                }

                DB::table('wallets')->updateOrInsert(
                    ['prahari_id' => $challan->prahari_id],
                    ['updated_at' => now(), 'created_at' => now()]
                );

                DB::table('wallets')
                    ->where('prahari_id', $challan->prahari_id)
                    ->increment('balance', $challan->amount);

                DB::table('transactions')->insert([
                    'prahari_id' => $challan->prahari_id,
                    'challan_id' => $challan->id,
                    'type' => 'credit',
                    'amount' => $challan->amount,
                    'description' => 'Challan payment received: '.$challan->challan_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

        DB::table('withdrawals')
            ->where('status', 'approved')
            ->orderBy('id')
            ->get()
            ->each(function ($withdrawal) {
                $description = 'Withdrawal approved to bank account '.$withdrawal->bank_account;

                $exists = DB::table('transactions')
                    ->where('prahari_id', $withdrawal->prahari_id)
                    ->where('type', 'debit')
                    ->where('amount', $withdrawal->amount)
                    ->where('description', $description)
                    ->exists();

                if ($exists) {
                    return;
                }

                DB::table('wallets')->updateOrInsert(
                    ['prahari_id' => $withdrawal->prahari_id],
                    ['updated_at' => now(), 'created_at' => now()]
                );

                DB::table('wallets')
                    ->where('prahari_id', $withdrawal->prahari_id)
                    ->decrement('balance', $withdrawal->amount);

                DB::table('transactions')->insert([
                    'prahari_id' => $withdrawal->prahari_id,
                    'challan_id' => null,
                    'type' => 'debit',
                    'amount' => $withdrawal->amount,
                    'description' => $description,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        DB::table('transactions')
            ->where(function ($query) {
                $query->where('description', 'like', 'Challan payment received:%')
                    ->orWhere('description', 'like', 'Withdrawal approved to bank account%');
            })
            ->delete();
    }
};
