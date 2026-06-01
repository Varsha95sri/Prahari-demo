<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prahari;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $withdrawals = Withdrawal::with('prahari')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('prahari', function ($prahariQuery) use ($search) {
                    $prahariQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('prahari_id', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $transactions = Transaction::with('prahari', 'challan')
            ->when($search, function ($query) use ($search) {
                $query->where('description', 'like', "%{$search}%")
                    ->orWhereHas('prahari', function ($prahariQuery) use ($search) {
                        $prahariQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('prahari_id', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->take(10)
            ->get();

        $wallets = Wallet::with('prahari')->latest()->take(10)->get();

        $summary      = [
            'wallet_balance' => Wallet::sum('balance'),
            'paid_amount' => Transaction::where('type', 'credit')->sum('amount'),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->sum('amount'),
            'total_transactions' => Transaction::count(),
        ];

        return view('admin.payments.index', compact('withdrawals', 'transactions', 'wallets', 'summary', 'search', 'status'));
    }

    public function create(Request $request)
    {
        $wallets = Wallet::with('prahari')
            ->where('balance', '>', 0)
            ->latest()
            ->get();

        $selectedPrahari = $request->integer('prahari_id');
        $praharis = Prahari::where('status', 'active')->orderBy('name')->get();

        return view('admin.payments.create', compact('wallets', 'praharis', 'selectedPrahari'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prahari_id' => 'required|exists:praharis,id',
            'amount' => 'required|numeric|min:1',
            'bank_account' => 'required|string|max:255',
            'ifsc' => 'required|string|max:50',
        ]);

        $wallet = Wallet::firstOrCreate(
            ['prahari_id' => $validated['prahari_id']],
            ['balance' => 0]
        );

        if ($wallet->balance < $validated['amount']) {
            return back()
                ->withInput()
                ->with('error', 'Withdrawal request create nahi hua: selected Prahari ke wallet me sufficient balance nahi hai.');
        }

        Withdrawal::create([
            'prahari_id' => $validated['prahari_id'],
            'amount' => $validated['amount'],
            'bank_account' => $validated['bank_account'],
            'ifsc' => $validated['ifsc'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Withdrawal request created successfully.');
    }

    public function approve($id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        $approved = DB::transaction(function () use ($withdrawal) {
            $wallet = Wallet::firstOrCreate(
                ['prahari_id' => $withdrawal->prahari_id],
                ['balance' => 0]
            );

            if ($wallet->balance < $withdrawal->amount) {
                return false;
            }

            $withdrawal->update(['status' => 'approved']);
            $wallet->decrement('balance', $withdrawal->amount);

            Transaction::create([
                'prahari_id' => $withdrawal->prahari_id,
                'challan_id' => null,
                'type' => 'debit',
                'amount' => $withdrawal->amount,
                'description' => 'Withdrawal approved to bank account '.$withdrawal->bank_account,
            ]);

            return true;
        });

        if (! $approved) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Withdrawal approve nahi hua: wallet balance insufficient hai.');
        }

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Withdrawal approved!');
    }

    public function reject($id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);
        $withdrawal->update(['status' => 'rejected']);

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Withdrawal rejected!');
    }
}
