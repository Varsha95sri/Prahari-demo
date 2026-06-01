<x-app-layout>
    <div class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Reports & Analytics</h1>
                <p class="mt-1 text-sm text-slate-500">Admin panel performance, case trend aur revenue summary.</p>
            </div>
            <div class="flex gap-2">
                <button class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export</button>
                <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Print</button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Total Cases</p>
                <p class="mt-2 text-2xl font-bold text-cyan-700">{{ $total_cases ?? 0 }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Total Challans</p>
                <p class="mt-2 text-2xl font-bold text-amber-700">{{ $total_challans ?? 0 }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Total Revenue</p>
                <p class="mt-2 text-2xl font-bold text-emerald-700">Rs. {{ number_format($total_revenue ?? 0, 2) }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Total Prahari</p>
                <p class="mt-2 text-2xl font-bold text-slate-950">{{ $total_prahari ?? 0 }}</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm xl:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-950">Case Trend</h2>
                    <span class="text-xs font-semibold text-slate-500">Last 7 periods</span>
                </div>
                @php
                    $caseValues = array_column($case_chart ?? [], 'value');
                    $caseMax = max(1, count($caseValues) ? max($caseValues) : 0);
                @endphp
                <div class="mt-5 flex h-64 items-end gap-4 border-b border-l border-slate-200 px-4" id="caseTrendBars">
                    @forelse($case_chart ?? [] as $point)
                        @php
                            $height = max(5, ((float) $point['value'] / $caseMax) * 100);
                        @endphp
                        <div class="flex flex-1 flex-col items-center justify-end gap-2">
                            <div class="w-full rounded-t bg-slate-800" data-target-height="{{ $height }}" style="height: 0;"></div>
                            <span class="text-[10px] font-medium text-slate-400">{{ $point['label'] }}</span>
                        </div>
                    @empty
                        <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">
                            No case trend data available.
                        </div>
                    @endforelse
                </div>
                @if(($total_cases ?? 0) == 0)
                    <p class="mt-3 text-xs text-slate-500">No cases available yet.</p>
                @endif
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Revenue Trend</h2>
                @php
                    $revenueValues = array_column($revenue_chart ?? [], 'value');
                    $revenueMax = max(1, count($revenueValues) ? max($revenueValues) : 0);
                @endphp
                <div class="mt-6 flex h-40 items-end gap-3 border-b border-l border-slate-200 px-3" id="revenueTrendBars">
                    @forelse($revenue_chart ?? [] as $point)
                        @php
                            $height = max(5, ((float) $point['value'] / $revenueMax) * 100);
                        @endphp
                        <div class="flex flex-1 flex-col items-center justify-end gap-2">
                            <div class="w-full rounded-t bg-emerald-600" data-target-height="{{ $height }}" style="height: 0;"></div>
                            <span class="text-[10px] font-medium text-slate-400">{{ $point['label'] }}</span>
                        </div>
                    @empty
                        <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">
                            No revenue trend data available.
                        </div>
                    @endforelse
                </div>
                <div class="mt-8 grid gap-3 text-sm">
                    <div class="flex items-center justify-between"><span class="text-slate-500">Total revenue</span><span class="font-semibold text-slate-950">Rs. {{ number_format($total_revenue ?? 0, 2) }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-slate-500">Paid challans</span><span class="font-semibold text-slate-950">{{ $total_challans ?? 0 }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-slate-500">Case records</span><span class="font-semibold text-slate-950">{{ $total_cases ?? 0 }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-slate-500">Prahari users</span><span class="font-semibold text-slate-950">{{ $total_prahari ?? 0 }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-target-height]').forEach(function (bar) {
                const height = bar.getAttribute('data-target-height');
                requestAnimationFrame(function () {
                    bar.style.transition = 'height 1.1s ease';
                    bar.style.height = height + '%';
                });
            });
        });
    </script>
</x-app-layout>
