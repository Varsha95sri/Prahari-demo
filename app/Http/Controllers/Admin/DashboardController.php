<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prahari;
use App\Models\Cases;
use App\Models\Challan;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_prahari'       => Prahari::count(),
            'active_prahari'      => Prahari::where('status', 'active')->count(),
            'total_cases'         => Cases::count(),
            'open_cases'          => Cases::where('status', 'open')->count(),
            'total_challans'      => Challan::count(),
            'total_revenue'       => Challan::where('status', 'paid')->sum('amount'),
            'wallet_balance'      => Wallet::sum('balance'),
            'total_transactions'  => Transaction::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'recent_praharis'     => Prahari::latest()->take(5)->get(),
            'recent_cases'        => Cases::latest()->take(5)->get(),
            'recent_challans'     => Challan::latest()->take(5)->get(),
            'case_chart'          => $this->caseChart(),
            'revenue_chart'       => $this->revenueChart(),
        ];

        return view('admin.dashboard', $data);
    }

    private function caseChart(): array
    {
        return collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'label' => $date->format('d M'),
                'value' => Cases::whereDate('created_at', $date)->count(),
            ];
        })->all();
    }

    private function revenueChart(): array
    {
        return collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'label' => $date->format('d M'),
                'value' => (float) Challan::where('status', 'paid')->whereDate('updated_at', $date)->sum('amount'),
            ];
        })->all();
    }
}
