<x-app-layout>
@php
    $caseChart = collect($case_chart ?? []);
    $revenueChart = collect($revenue_chart ?? []);
    $maxCases = max(1, (int) $caseChart->max('value'));
    $maxRevenue = max(1, (float) $revenueChart->max('value'));

    $stats = [
        ['label' => 'Total Prahari', 'value' => number_format($total_prahari ?? 0), 'sub' => number_format($active_prahari ?? 0).' active members', 'tone' => 'bg-teal-50 text-teal-800', 'bar' => 'bg-teal-600'],
        ['label' => 'Total Cases', 'value' => number_format($total_cases ?? 0), 'sub' => number_format($open_cases ?? 0).' open cases', 'tone' => 'bg-sky-50 text-sky-800', 'bar' => 'bg-sky-600'],
        ['label' => 'Total Challans', 'value' => number_format($total_challans ?? 0), 'sub' => 'Rs. '.number_format($total_revenue ?? 0, 2).' revenue', 'tone' => 'bg-amber-50 text-amber-800', 'bar' => 'bg-amber-500'],
        ['label' => 'Wallet Balance', 'value' => 'Rs. '.number_format($wallet_balance ?? 0, 2), 'sub' => number_format($total_transactions ?? 0).' transactions', 'tone' => 'bg-emerald-50 text-emerald-800', 'bar' => 'bg-emerald-600'],
    ];
@endphp

<div class="mx-auto max-w-7xl space-y-6">
    <section class="rounded-md border border-slate-200 bg-white shadow-sm">
        <div class="grid gap-5 border-b border-slate-200 px-4 py-5 sm:px-6 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
            <div>
                <p class="text-xs font-black uppercase tracking-wide text-teal-700">Admin Dashboard</p>
                <h1 class="mt-2 break-words text-2xl font-black text-slate-950 sm:text-3xl">
                    Welcome, {{ Auth::user()->name }}
                </h1>
                <p class="mt-2 max-w-2xl text-sm font-medium text-slate-600">
                    Prahari records, cases, challans, wallet activity and reports in one control panel.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:w-[460px]">
                <a href="{{ route('admin.praharis.create') }}" class="inline-flex justify-center rounded-md bg-teal-700 px-4 py-3 text-sm font-black text-white transition hover:bg-teal-800">Add Prahari</a>
                <a href="{{ route('admin.cases.create') }}" class="inline-flex justify-center rounded-md border border-slate-300 px-4 py-3 text-sm font-black text-slate-800 transition hover:bg-slate-50">New Case</a>
                <a href="{{ route('admin.payments.index') }}" class="inline-flex justify-center rounded-md border border-slate-300 px-4 py-3 text-sm font-black text-slate-800 transition hover:bg-slate-50">Payments</a>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex justify-center rounded-md border border-slate-300 px-4 py-3 text-sm font-black text-slate-800 transition hover:bg-slate-50">Reports</a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 sm:p-6 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="rounded-md border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="mb-4 h-1.5 rounded-full {{ $stat['bar'] }}"></div>
                    <p class="text-sm font-bold text-slate-600">{{ $stat['label'] }}</p>
                    <p class="mt-2 break-words text-2xl font-black text-slate-950 sm:text-3xl">{{ $stat['value'] }}</p>
                    <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-black {{ $stat['tone'] }}">{{ $stat['sub'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
        <div class="rounded-md border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                <div>
                    <h2 class="text-base font-black text-slate-950">Case Analytics</h2>
                    <p class="text-sm font-medium text-slate-600">Last 7 days case registrations</p>
                </div>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-black text-sky-800">{{ number_format($caseChart->sum('value')) }} cases</span>
            </div>

            <div class="grid h-auto min-h-80 grid-cols-7 items-end gap-3 px-4 py-6 sm:px-5">
                @forelse($caseChart as $point)
                    @php($height = max(10, ((int) $point['value'] / $maxCases) * 100))
                    <div class="flex min-w-0 flex-col items-center gap-2">
                        <span class="text-xs font-black text-slate-800">{{ $point['value'] }}</span>
                        <div class="flex h-52 w-full items-end rounded bg-slate-100">
                            <div class="w-full rounded bg-sky-600" style="height: {{ $height }}%;"></div>
                        </div>
                        <span class="w-full truncate text-center text-[11px] font-bold text-slate-500">{{ $point['label'] }}</span>
                    </div>
                @empty
                    <p class="col-span-7 rounded-md bg-slate-50 px-4 py-10 text-center text-sm font-semibold text-slate-500">No case data available.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-md border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-black text-slate-950">Revenue</h2>
                    <p class="text-sm font-medium text-slate-600">Paid challans in last 7 days</p>
                </div>

                <div class="space-y-4 px-5 py-5">
                    @forelse($revenueChart as $point)
                        @php($width = max(4, (((float) $point['value']) / $maxRevenue) * 100))
                        <div>
                            <div class="mb-1 flex items-center justify-between gap-3 text-xs">
                                <span class="font-bold text-slate-600">{{ $point['label'] }}</span>
                                <span class="font-black text-slate-950">Rs. {{ number_format($point['value'], 2) }}</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-emerald-600" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="rounded-md bg-slate-50 px-4 py-8 text-center text-sm font-semibold text-slate-500">No revenue data available.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-md border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-black text-slate-950">Quick Status</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    <div class="flex items-center justify-between gap-3 px-5 py-4">
                        <span class="text-sm font-bold text-slate-600">Pending Withdrawals</span>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-black text-amber-800">{{ $pending_withdrawals ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-3 px-5 py-4">
                        <span class="text-sm font-bold text-slate-600">Open Cases</span>
                        <span class="rounded-full bg-sky-100 px-3 py-1 text-sm font-black text-sky-800">{{ $open_cases ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-3 px-5 py-4">
                        <span class="text-sm font-bold text-slate-600">Active Prahari</span>
                        <span class="rounded-full bg-teal-100 px-3 py-1 text-sm font-black text-teal-800">{{ $active_prahari ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-md border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-black text-slate-950">Recent Prahari</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse(($recent_praharis ?? collect()) as $prahari)
                    <div class="px-5 py-4">
                        <p class="break-words font-black text-slate-950">{{ $prahari->name }}</p>
                        <p class="mt-1 break-words text-xs font-semibold text-slate-500">{{ $prahari->prahari_id ?? 'ID not assigned' }}{{ $prahari->phone ? ' / '.$prahari->phone : '' }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm font-semibold text-slate-500">No Prahari records found.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-md border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-black text-slate-950">Recent Cases</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse(($recent_cases ?? collect()) as $case)
                    <div class="px-5 py-4">
                        <p class="break-words font-black text-slate-950">{{ $case->type ?? $case->case_id ?? 'Case #'.$case->id }}</p>
                        <p class="mt-1 break-words text-xs font-semibold text-slate-500">{{ $case->case_id ?? 'No case ID' }} / {{ ucfirst(str_replace('_', ' ', $case->status ?? 'open')) }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm font-semibold text-slate-500">No case records found.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-md border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-black text-slate-950">Recent Challans</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse(($recent_challans ?? collect()) as $challan)
                    <div class="flex items-start justify-between gap-4 px-5 py-4">
                        <div class="min-w-0">
                            <p class="break-words font-black text-slate-950">{{ $challan->challan_id ?? 'Challan #'.$challan->id }}</p>
                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ ucfirst($challan->status ?? 'pending') }}</p>
                        </div>
                        <p class="shrink-0 whitespace-nowrap text-sm font-black text-slate-950">Rs. {{ number_format($challan->amount ?? 0, 2) }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm font-semibold text-slate-500">No challan records found.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
</x-app-layout>
