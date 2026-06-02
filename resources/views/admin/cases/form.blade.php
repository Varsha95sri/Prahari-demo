<div class="form-grid">
    <div class="form-group">
        <label for="prahari_id">Prahari</label>
        <select id="prahari_id" name="prahari_id" class="form-control" required>
            <option value="">Select Prahari</option>
            @foreach($praharis as $prahari)
                <option value="{{ $prahari->id }}" @selected(old('prahari_id', $case?->prahari_id) == $prahari->id)>
                    {{ $prahari->name }} - {{ $prahari->phone }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('prahari_id')" class="error-message" />
    </div>

    <div class="form-group">
        <label for="type">Case Type</label>
        <input id="type" name="type" type="text" class="form-control" value="{{ old('type', $case?->type) }}" required />
        <x-input-error :messages="$errors->get('type')" class="error-message" />
    </div>

    <div class="form-group">
        <label for="location">Location</label>
        <input id="location" name="location" type="text" class="form-control" value="{{ old('location', $case?->location) }}" required />
        <x-input-error :messages="$errors->get('location')" class="error-message" />
    </div>

    @if($case)
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="open" @selected(old('status', $case->status) === 'open')>Open</option>
                <option value="in_progress" @selected(old('status', $case->status) === 'in_progress')>In Progress</option>
                <option value="closed" @selected(old('status', $case->status) === 'closed')>Closed</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="error-message" />
        </div>
    @endif

    <div class="form-group {{ $case ? 'col-span-2' : '' }}">
        <label for="document">Case Image / Video / Document</label>
        <input id="document" name="document" type="file" accept="image/*,video/*,.pdf" class="form-control file-input" />
        <p class="help-text">Images, videos or PDF up to 20 MB.</p>
        <x-input-error :messages="$errors->get('document')" class="error-message" />
    </div>

    <div class="form-group col-span-2">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5" class="form-control" required>{{ old('description', $case?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="error-message" />
    </div>
</div>

