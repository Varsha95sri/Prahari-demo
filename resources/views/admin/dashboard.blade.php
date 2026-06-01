<x-app-layout>
@php
    $caseChart = collect($case_chart ?? []);
    $revenueChart = collect($revenue_chart ?? []);
    $maxCases = max(1, (int) $caseChart->max('value'));
    $maxRevenue = max(1, (float) $revenueChart->max('value'));

    $stats = [
        ['label' => 'Total Prahari', 'value' => number_format($total_prahari ?? 0), 'sub' => number_format($active_prahari ?? 0).' active', 'tone' => 'text-slate-950'],
        ['label' => 'Total Cases', 'value' => number_format($total_cases ?? 0), 'sub' => number_format($open_cases ?? 0).' open cases', 'tone' => 'text-cyan-700'],
        ['label' => 'Total Challans', 'value' => number_format($total_challans ?? 0), 'sub' => 'Rs. '.number_format($total_revenue ?? 0, 2).' revenue', 'tone' => 'text-amber-700'],
        ['label' => 'Wallet Balance', 'value' => 'Rs. '.number_format($wallet_balance ?? 0, 2), 'sub' => number_format($total_transactions ?? 0).' transactions', 'tone' => 'text-emerald-700'],
    ];
@endphp

<div class="mx-auto max-w-7xl space-y-6 px-0 py-1 sm:px-2 lg:px-0">
    <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-950 px-5 py-6 text-white sm:px-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-cyan-300">Admin Dashboard</p>
                    <h1 class="mt-2 text-2xl font-black sm:text-3xl">
                        Welcome, {{ Auth::user()->name }}
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-300">
                        Prahari records, cases, challans, wallet activity and withdrawals in one place.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:w-auto xl:grid-cols-4">
                    <a href="{{ route('admin.praharis.create') }}" class="inline-flex justify-center rounded-md bg-cyan-400 px-4 py-2.5 text-sm font-black text-slate-950 transition hover:bg-cyan-300">
                        Add Prahari
                    </a>
                    <a href="{{ route('admin.cases.create') }}" class="inline-flex justify-center rounded-md border border-white/20 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">
                        New Case
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="inline-flex justify-center rounded-md border border-white/20 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">
                        Payments
                    </a>
                    <a href="{{ route('profile.edit') }}" class="inline-flex justify-center rounded-md border border-white/20 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">
                        My Account
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 divide-y divide-slate-200 sm:grid-cols-2 sm:divide-x sm:divide-y-0 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="p-5">
                    <p class="text-sm font-semibold text-slate-500">{{ $stat['label'] }}</p>
                    <p class="mt-2 break-words text-3xl font-black {{ $stat['tone'] }}">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $stat['sub'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-black text-slate-950">Case Analytics</h2>
                    <p class="text-sm text-slate-500">Last 7 days case registrations</p>
                </div>
                <span class="rounded-full bg-cyan-50 px-3 py-1 text-xs font-bold text-cyan-700">
                    {{ number_format($caseChart->sum('value')) }} cases
                </span>
            </div>

            <div class="h-80 overflow-hidden px-5 py-5">
                <canvas id="caseTrendCanvas" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-black text-slate-950">Revenue</h2>
                    <p class="text-sm text-slate-500">Paid challans in last 7 days</p>
                </div>

                <div class="space-y-4 px-5 py-5">
                    @forelse($revenueChart as $point)
                        @php($width = max(4, (((float) $point['value']) / $maxRevenue) * 100))
                        <div>
                            <div class="mb-1 flex items-center justify-between gap-3 text-xs">
                                <span class="font-semibold text-slate-600">{{ $point['label'] }}</span>
                                <span class="font-bold text-slate-950">Rs. {{ number_format($point['value'], 2) }}</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="rounded-lg bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">No revenue data available.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-black text-slate-950">Quick Status</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    <div class="flex items-center justify-between px-5 py-4">
                        <span class="text-sm font-semibold text-slate-600">Pending Withdrawals</span>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-black text-amber-700">{{ $pending_withdrawals ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-4">
                        <span class="text-sm font-semibold text-slate-600">Open Cases</span>
                        <span class="rounded-full bg-cyan-100 px-3 py-1 text-sm font-black text-cyan-700">{{ $open_cases ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-4">
                        <span class="text-sm font-semibold text-slate-600">Active Prahari</span>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-black text-emerald-700">{{ $active_prahari ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-black text-slate-950">Recent Prahari</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse(($recent_praharis ?? collect()) as $prahari)
                    <div class="px-5 py-4">
                        <p class="font-bold text-slate-950">{{ $prahari->name }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $prahari->prahari_id ?? 'ID not assigned' }} {{ $prahari->phone ? ' / '.$prahari->phone : '' }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-500">No Prahari records found.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-black text-slate-950">Recent Cases</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse(($recent_cases ?? collect()) as $case)
                    <div class="px-5 py-4">
                        <p class="font-bold text-slate-950">{{ $case->title ?? $case->case_number ?? 'Case #'.$case->id }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ ucfirst($case->status ?? 'open') }} {{ $case->created_at ? ' / '.$case->created_at->format('d M Y') : '' }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-500">No case records found.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-black text-slate-950">Recent Challans</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse(($recent_challans ?? collect()) as $challan)
                    <div class="flex items-start justify-between gap-4 px-5 py-4">
                        <div>
                            <p class="font-bold text-slate-950">{{ $challan->challan_no ?? 'Challan #'.$challan->id }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ ucfirst($challan->status ?? 'pending') }}</p>
                        </div>
                        <p class="whitespace-nowrap text-sm font-black text-slate-950">Rs. {{ number_format($challan->amount ?? 0, 2) }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-500">No challan records found.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const caseData = @json($caseChart->pluck('value'));
        const caseLabels = @json($caseChart->pluck('label'));
        const revenueData = @json($revenueChart->pluck('value'));
        const revenueLabels = @json($revenueChart->pluck('label'));

        function createChart(canvasId, labels, data, color) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;
            canvas.width = width * window.devicePixelRatio;
            canvas.height = height * window.devicePixelRatio;
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
            ctx.fillStyle = 'transparent';
            ctx.fillRect(0, 0, width, height);
            const max = Math.max(1, ...data.map(v => Number(v)));
            const barWidth = Math.max(24, (width - 40) / Math.max(labels.length, 1) - 12);
            data.forEach((value, index) => {
                const x = 20 + index * (barWidth + 12);
                const barHeight = Math.max(16, (Number(value) / max) * (height - 50));
                ctx.fillStyle = color;
                ctx.fillRect(x, height - barHeight - 24, barWidth, barHeight);
                ctx.fillStyle = '#334155';
                ctx.font = '12px Inter, ui-sans-serif, system-ui';
                ctx.textAlign = 'center';
                ctx.fillText(value, x + barWidth / 2, height - barHeight - 30);
                ctx.fillStyle = '#64748b';
                ctx.fillText(labels[index], x + barWidth / 2, height - 8);
            });
        }

        createChart('caseTrendCanvas', caseLabels, caseData, '#06b6d4');
        createChart('revenueTrendCanvas', revenueLabels, revenueData, '#16a34a');
    });
</script>
</x-app-layout>
