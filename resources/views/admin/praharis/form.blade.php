<div class="space-y-6">
    <section class="rounded-md border border-slate-200 bg-slate-50 p-4">
        <h2 class="text-base font-bold text-slate-950">Basic Details</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="name" value="Full Name" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-slate-950" value="{{ old('name', $prahari?->name) }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-slate-950 disabled:bg-slate-100 disabled:text-slate-500" value="{{ old('email', $prahari?->email) }}" :disabled="$prahari !== null" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="phone" value="Phone Number" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full text-slate-950" value="{{ old('phone', $prahari?->phone) }}" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            @if(!$prahari)
                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full text-slate-950" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            @endif
            @if($prahari)
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 text-slate-950 shadow-sm focus:border-teal-600 focus:ring-teal-600">
                        <option value="active" @selected(old('status', $prahari->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $prahari->status) === 'inactive')>Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            @endif
        </div>
    </section>

    <section class="rounded-md border border-slate-200 bg-white p-4">
        <h2 class="text-base font-bold text-slate-950">Aadhaar And Date</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <x-input-label for="aadhaar_number" value="Aadhaar Number" />
                <x-text-input id="aadhaar_number" name="aadhaar_number" type="text" inputmode="numeric" maxlength="12" class="mt-1 block w-full text-slate-950" value="{{ old('aadhaar_number', $prahari?->aadhaar_number) }}" placeholder="12 digit number" />
                <x-input-error :messages="$errors->get('aadhaar_number')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="record_date" value="Date" />
                <x-text-input id="record_date" name="record_date" type="date" class="mt-1 block w-full text-slate-950" value="{{ old('record_date', $prahari?->record_date?->format('Y-m-d')) }}" />
                <x-input-error :messages="$errors->get('record_date')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="bank_account" value="Bank Account" />
                <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full text-slate-950" value="{{ old('bank_account', $prahari?->bank_account) }}" />
                <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
            </div>
        </div>
    </section>

    <section class="rounded-md border border-slate-200 bg-white p-4">
        <h2 class="text-base font-bold text-slate-950">Image And Video</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="image" value="Upload Image" />
                <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 file:mr-3 file:rounded file:border-0 file:bg-teal-700 file:px-3 file:py-2 file:text-sm file:font-bold file:text-white focus:border-teal-600 focus:ring-teal-600" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                @if($prahari?->image_path)
                    <img src="{{ asset('storage/'.$prahari->image_path) }}" alt="Prahari image" class="mt-3 h-32 w-full rounded-md border border-slate-200 object-cover sm:w-56" />
                @endif
            </div>
            <div>
                <x-input-label for="video" value="Upload Video" />
                <input id="video" name="video" type="file" accept="video/*" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 file:mr-3 file:rounded file:border-0 file:bg-teal-700 file:px-3 file:py-2 file:text-sm file:font-bold file:text-white focus:border-teal-600 focus:ring-teal-600" />
                <x-input-error :messages="$errors->get('video')" class="mt-2" />
                @if($prahari?->video_path)
                    <video src="{{ asset('storage/'.$prahari->video_path) }}" controls class="mt-3 h-32 w-full rounded-md border border-slate-200 bg-black object-cover sm:w-56"></video>
                @endif
            </div>
        </div>
    </section>
</div>
