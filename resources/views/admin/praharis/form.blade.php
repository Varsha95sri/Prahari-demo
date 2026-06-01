<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $prahari?->name) }}" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $prahari?->email) }}" :disabled="$prahari !== null" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="phone" value="Phone" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $prahari?->phone) }}" required />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="aadhaar_number" value="Aadhaar Number (optional)" />
        <x-text-input id="aadhaar_number" name="aadhaar_number" type="text" class="mt-1 block w-full" value="{{ old('aadhaar_number', $prahari?->aadhaar_number) }}" />
        <x-input-error :messages="$errors->get('aadhaar_number')" class="mt-2" />
    </div>
    @if(!$prahari)
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
    @endif
    @if($prahari)
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                <option value="active" @selected(old('status', $prahari->status) === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $prahari->status) === 'inactive')>Inactive</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    @endif
</div>
