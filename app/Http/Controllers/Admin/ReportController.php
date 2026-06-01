<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\Challan;
use App\Models\Prahari;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $data = [
            'total_cases'    => Cases::count(),
            'total_challans' => Challan::count(),
            'total_revenue'  => Challan::where('status', 'paid')->sum('amount'),
            'total_prahari'  => Prahari::count(),
            'case_chart'     => $this->caseChart(),
            'revenue_chart'  => $this->revenueChart(),
        ];

        return view('admin.reports.index', $data);
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
                'value' => (float) Transaction::where('type', 'credit')->whereDate('created_at', $date)->sum('amount'),
            ];
        })->all();
    }
}
