<x-app-layout>
    <div class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Payments / Withdrawals</h1>
                <p class="mt-1 text-sm text-slate-500">Wallet credits, withdrawal requests aur approval status.</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('admin.payments.create') }}" class="inline-flex justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Request Withdrawal</a>
                <a href="{{ route('admin.challans.index') }}" class="inline-flex justify-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Manage Challans</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Available Wallet</p>
                <p class="mt-2 text-2xl font-bold text-emerald-700">Rs. {{ number_format($summary['wallet_balance'] ?? 0, 2) }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Total Credits</p>
                <p class="mt-2 text-2xl font-bold text-cyan-700">Rs. {{ number_format($summary['paid_amount'] ?? 0, 2) }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Pending Withdrawals</p>
                <p class="mt-2 text-2xl font-bold text-amber-700">Rs. {{ number_format($summary['pending_withdrawals'] ?? 0, 2) }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">Transactions</p>
                <p class="mt-2 text-2xl font-bold text-slate-950">{{ $summary['total_transactions'] ?? 0 }}</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex rounded-md bg-slate-100 p-1 text-sm font-semibold">
                            <a href="{{ route('admin.payments.index', request()->except('status')) }}" class="rounded px-3 py-1.5 {{ $status === '' ? 'bg-white text-slate-950 shadow-sm' : 'text-slate-500' }}">All Withdrawals</a>
                            <a href="{{ route('admin.payments.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" class="rounded px-3 py-1.5 {{ $status === 'pending' ? 'bg-white text-slate-950 shadow-sm' : 'text-slate-500' }}">Pending</a>
                            <a href="{{ route('admin.payments.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}" class="rounded px-3 py-1.5 {{ $status === 'approved' ? 'bg-white text-slate-950 shadow-sm' : 'text-slate-500' }}">Approved</a>
                        </div>

                        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-col gap-2 sm:flex-row">
                            @if($status)
                                <input type="hidden" name="status" value="{{ $status }}">
                            @endif
                            <input name="search" value="{{ $search }}" type="search" placeholder="Search by Prahari, phone, ID..." class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:w-72">
                            <button class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                            <tr>
                                <th class="px-5 py-3">#</th>
                                <th class="px-5 py-3">Request ID</th>
                                <th class="px-5 py-3">Prahari</th>
                                <th class="px-5 py-3">Amount</th>
                                <th class="px-5 py-3">Bank Account</th>
                                <th class="px-5 py-3">IFSC</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Date</th>
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($withdrawals as $withdrawal)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4 text-slate-600">{{ $withdrawals->firstItem() + $loop->index }}</td>
                                    <td class="px-5 py-4 font-semibold text-slate-950">WD{{ str_pad($withdrawal->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-950">{{ $withdrawal->prahari?->name ?? '-' }}</div>
                                        <div class="text-xs text-slate-500">{{ $withdrawal->prahari?->prahari_id ?? '' }} {{ $withdrawal->prahari?->phone ? ' / '.$withdrawal->prahari->phone : '' }}</div>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-slate-950">Rs. {{ number_format($withdrawal->amount, 2) }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $withdrawal->bank_account }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $withdrawal->ifsc }}</td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $withdrawal->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($withdrawal->status === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-slate-500">{{ $withdrawal->created_at?->format('d M Y') }}</td>
                                    <td class="px-5 py-4">
                                        @if($withdrawal->status === 'pending')
                                            <div class="flex justify-end gap-2">
                                                <form id="approve-{{ $withdrawal->id }}" method="POST" action="{{ route('admin.payments.approve', $withdrawal->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" class="js-action rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white" data-message="Approve this withdrawal?" data-form-id="approve-{{ $withdrawal->id }}">Approve</button>
                                                </form>
                                                <form id="reject-{{ $withdrawal->id }}" method="POST" action="{{ route('admin.payments.reject', $withdrawal->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" class="js-action rounded-md bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white" data-message="Reject this withdrawal?" data-form-id="reject-{{ $withdrawal->id }}">Reject</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="block text-right text-xs text-slate-400">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-5 py-10 text-center text-slate-500">
                                        No withdrawal requests found.
                                        <a href="{{ route('admin.payments.create') }}" class="ml-2 font-semibold text-cyan-700">Create request</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-slate-200 px-5 py-4">{{ $withdrawals->links() }}</div>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Wallet Balances</h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($wallets as $wallet)
                            <div class="flex items-center justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="font-semibold text-slate-950">{{ $wallet->prahari?->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $wallet->prahari?->phone ?? '' }}</p>
                                </div>
                                <p class="font-bold text-emerald-700">Rs. {{ number_format($wallet->balance, 2) }}</p>
                            </div>
                        @empty
                            <p class="px-5 py-8 text-center text-sm text-slate-500">No wallets found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Recent Transactions</h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($transactions as $transaction)
                            <div class="px-5 py-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-950">{{ $transaction->prahari?->name ?? '-' }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $transaction->description }}</p>
                                    </div>
                                    <p class="whitespace-nowrap font-bold {{ $transaction->type === 'credit' ? 'text-emerald-700' : 'text-rose-700' }}">
                                        {{ $transaction->type === 'credit' ? '+' : '-' }} Rs. {{ number_format($transaction->amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="px-5 py-8 text-center text-sm text-slate-500">No transactions found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Confirm Delete/Action Modal -->
<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-slate-900">Confirm action</h3>
        <p id="confirmMessage" class="mt-2 text-sm text-slate-600">Are you sure you want to continue?</p>
        <div class="mt-4 flex justify-end gap-3">
            <button id="confirmNo" type="button" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">No</button>
            <button id="confirmYes" type="button" class="inline-flex justify-center rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white">Yes</button>
        </div>
    </div>
</div>

<script>
    (function(){
        let currentForm = null;
        document.querySelectorAll('.js-action').forEach(btn => {
            btn.addEventListener('click', function(){
                const msg = this.dataset.message || 'Are you sure?';
                const fid = this.dataset.formId;
                currentForm = document.getElementById(fid);
                document.getElementById('confirmMessage').textContent = msg;
                document.getElementById('confirmModal').classList.remove('hidden');
            });
        });
        document.getElementById('confirmNo').addEventListener('click', function(){
            document.getElementById('confirmModal').classList.add('hidden');
            currentForm = null;
        });
        document.getElementById('confirmYes').addEventListener('click', function(){
            if(currentForm) currentForm.submit();
        });
    })();
</script>
