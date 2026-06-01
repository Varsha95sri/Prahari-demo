<x-app-layout>
    <div class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-950">Request Withdrawal</h1>
                    <p class="mt-1 text-sm text-slate-500">Wallet balance se bank withdrawal request create karein.</p>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="inline-flex justify-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Back</a>
            </div>

            @if(session('error'))
                <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <form method="POST" action="{{ route('admin.payments.store') }}" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-input-label for="prahari_id" value="Prahari" />
                            <select id="prahari_id" name="prahari_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                                <option value="">Select Prahari</option>
                                @foreach($praharis as $prahari)
                                    @php($walletBalance = optional($wallets->firstWhere('prahari_id', $prahari->id))->balance ?? 0)
                                    <option value="{{ $prahari->id }}" @selected(old('prahari_id', $selectedPrahari) == $prahari->id)>
                                        {{ $prahari->name }} - {{ $prahari->phone }} (Wallet Rs. {{ number_format($walletBalance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prahari_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" value="Amount" />
                            <x-text-input id="amount" name="amount" type="number" min="1" step="0.01" class="mt-1 block w-full" value="{{ old('amount') }}" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="ifsc" value="IFSC" />
                            <x-text-input id="ifsc" name="ifsc" type="text" class="mt-1 block w-full uppercase" value="{{ old('ifsc') }}" required />
                            <x-input-error :messages="$errors->get('ifsc')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="bank_account" value="Bank Account" />
                            <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full" value="{{ old('bank_account') }}" required />
                            <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-between sm:items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex justify-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back to Dashboard</a>
                        <button class="inline-flex justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Submit Request</button>
                    </div>
                </form>

                <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Available Wallets</h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($wallets as $wallet)
                            <div class="px-5 py-4">
                                <p class="font-semibold text-slate-950">{{ $wallet->prahari?->name ?? '-' }}</p>
                                <p class="mt-1 text-sm font-bold text-emerald-700">Rs. {{ number_format($wallet->balance, 2) }}</p>
                            </div>
                        @empty
                            <p class="px-5 py-8 text-center text-sm text-slate-500">Paid challan ke baad wallet balance yahan dikhega.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
