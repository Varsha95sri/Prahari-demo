<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challan;
use App\Models\Cases;
use App\Models\Prahari;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallanController extends Controller
{
    public function index()
    {
        $challans = Challan::with(['prahari', 'case'])->latest()->paginate(10);
        return view('admin.challans.index', compact('challans'));
    }

    public function create()
    {
        $cases    = Cases::all();
        $praharis = Prahari::where('status', 'active')->get();
        return view('admin.challans.create', compact('cases', 'praharis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'case_id'    => 'required|exists:cases,id',
            'prahari_id' => 'required|exists:praharis,id',
            'amount'     => 'required|numeric|min:1',
        ]);

        Challan::create([
            'challan_id' => 'CHL' . rand(10000, 99999),
            'case_id'    => $request->case_id,
            'prahari_id' => $request->prahari_id,
            'amount'     => $request->amount,
            'status'     => 'pending',
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Challan created successfully!');
    }

    public function update(Request $request, Challan $challan)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        DB::transaction(function () use ($request, $challan) {
            $oldStatus = $challan->status;
            $newStatus = $request->status;

            $challan->update(['status' => $newStatus]);

            if ($oldStatus !== 'paid' && $newStatus === 'paid') {
                $wallet = Wallet::firstOrCreate(
                    ['prahari_id' => $challan->prahari_id],
                    ['balance' => 0]
                );

                $wallet->increment('balance', $challan->amount);

                Transaction::create([
                    'prahari_id' => $challan->prahari_id,
                    'challan_id' => $challan->id,
                    'type' => 'credit',
                    'amount' => $challan->amount,
                    'description' => 'Challan payment received: '.$challan->challan_id,
                ]);
            }

            if ($oldStatus === 'paid' && $newStatus !== 'paid') {
                $wallet = Wallet::firstOrCreate(
                    ['prahari_id' => $challan->prahari_id],
                    ['balance' => 0]
                );

                $wallet->decrement('balance', min($wallet->balance, $challan->amount));

                Transaction::create([
                    'prahari_id' => $challan->prahari_id,
                    'challan_id' => $challan->id,
                    'type' => 'debit',
                    'amount' => $challan->amount,
                    'description' => 'Challan payment reversed: '.$challan->challan_id,
                ]);
            }
        });

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Challan updated successfully!');
    }

    public function destroy(Challan $challan)
    {
        $challan->delete();
        return redirect()->route('admin.challans.index')
                         ->with('success', 'Challan deleted successfully!');
    }

    public function show(Challan $challan)
    {
        return view('admin.challans.show', compact('challan'));
    }

    public function edit(Challan $challan)
    {
        $cases    = Cases::all();
        $praharis = Prahari::all();
        return view('admin.challans.edit', compact('challan', 'cases', 'praharis'));
    }
}
