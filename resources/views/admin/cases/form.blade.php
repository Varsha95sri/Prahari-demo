<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="prahari_id" value="Prahari" />
        <select id="prahari_id" name="prahari_id" class="mt-1 block w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-0 focus:ring-2 focus:ring-cyan-400" required>
            <option value="">Select Prahari</option>
            @foreach($praharis as $prahari)
                <option value="{{ $prahari->id }}" @selected(old('prahari_id', $case?->prahari_id) == $prahari->id)>{{ $prahari->name }} - {{ $prahari->phone }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('prahari_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="type" value="Case Type" />
        <x-text-input id="type" name="type" type="text" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-0 focus:ring-2 focus:ring-cyan-400" value="{{ old('type', $case?->type) }}" required />
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="location" value="Location" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-0 focus:ring-2 focus:ring-cyan-400" value="{{ old('location', $case?->location) }}" required />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>
    @if($case)
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-0 focus:ring-2 focus:ring-cyan-400" required>
                <option value="open" @selected(old('status', $case->status) === 'open')>Open</option>
                <option value="in_progress" @selected(old('status', $case->status) === 'in_progress')>In Progress</option>
                <option value="closed" @selected(old('status', $case->status) === 'closed')>Closed</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    @else
        <div>
            <x-input-label for="document" value="Document" />
            <input id="document" name="document" type="file" class="mt-1 block w-full rounded-lg border-2 border-dashed border-gray-200 px-3 py-2 text-sm shadow-sm focus:border-0 focus:ring-2 focus:ring-cyan-400" />
        </div>
    @endif
    <div class="sm:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-0 focus:ring-2 focus:ring-cyan-400" required>{{ old('description', $case?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>
