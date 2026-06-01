<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    @if(!$challan)
        <div>
            <x-input-label for="case_id" value="Case" />
            <select id="case_id" name="case_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                <option value="">Select Case</option>
                @foreach($cases as $case)
                    <option value="{{ $case->id }}" @selected(old('case_id', $challan?->case_id) == $case->id)>{{ $case->case_id }} - {{ $case->type }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('case_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="prahari_id" value="Prahari" />
            <select id="prahari_id" name="prahari_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                <option value="">Select Prahari</option>
                @foreach($praharis as $prahari)
                    <option value="{{ $prahari->id }}" @selected(old('prahari_id', $challan?->prahari_id) == $prahari->id)>{{ $prahari->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('prahari_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="amount" value="Amount" />
            <x-text-input id="amount" name="amount" type="number" min="1" step="0.01" class="mt-1 block w-full" value="{{ old('amount', $challan?->amount) }}" required />
            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
        </div>
    @else
        <div>
            <x-input-label value="Challan" />
            <div class="mt-1 rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-800">{{ $challan->challan_id }}</div>
        </div>
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                <option value="pending" @selected(old('status', $challan->status) === 'pending')>Pending</option>
                <option value="paid" @selected(old('status', $challan->status) === 'paid')>Paid</option>
                <option value="cancelled" @selected(old('status', $challan->status) === 'cancelled')>Cancelled</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    @endif
</div>
