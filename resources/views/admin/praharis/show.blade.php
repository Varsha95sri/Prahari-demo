<x-app-layout>
    <div class="px-0 py-2 sm:px-2">
        <div class="mx-auto max-w-5xl">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="break-words text-2xl font-black text-slate-950">{{ $prahari->name }}</h1>
                    <p class="mt-1 text-sm font-semibold text-slate-500">{{ $prahari->prahari_id }}</p>
                </div>
                <a href="{{ route('admin.praharis.edit', $prahari) }}" class="inline-flex justify-center rounded-md bg-teal-700 px-4 py-2 text-sm font-bold text-white hover:bg-teal-800">Edit</a>
            </div>

            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Email</p>
                    <p class="mt-2 break-words font-bold text-slate-950">{{ $prahari->email }}</p>
                </div>
                <div class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Phone</p>
                    <p class="mt-2 break-words font-bold text-slate-950">{{ $prahari->phone }}</p>
                </div>
                <div class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Status</p>
                    <p class="mt-2 font-bold text-slate-950">{{ ucfirst($prahari->status) }}</p>
                </div>
                <div class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Aadhaar Number</p>
                    <p class="mt-2 break-words font-bold text-slate-950">{{ $prahari->aadhaar_number ?? '-' }}</p>
                </div>
                <div class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Date</p>
                    <p class="mt-2 font-bold text-slate-950">{{ $prahari->record_date?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Bank Account</p>
                    <p class="mt-2 break-words font-bold text-slate-950">{{ $prahari->bank_account ?? '-' }}</p>
                </div>
            </section>

            <section class="mt-6 rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-black text-slate-950">Image And Video</h2>
                <div class="mt-4 grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Image</p>
                        @if($prahari->image_path)
                            <img src="{{ asset('storage/'.$prahari->image_path) }}" alt="Prahari image" class="mt-2 aspect-video w-full rounded-md border border-slate-200 object-cover" />
                        @else
                            <p class="mt-2 rounded-md bg-slate-50 px-4 py-8 text-center text-sm font-semibold text-slate-500">No image uploaded.</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Video</p>
                        @if($prahari->video_path)
                            <video src="{{ asset('storage/'.$prahari->video_path) }}" controls class="mt-2 aspect-video w-full rounded-md border border-slate-200 bg-black object-cover"></video>
                        @else
                            <p class="mt-2 rounded-md bg-slate-50 px-4 py-8 text-center text-sm font-semibold text-slate-500">No video uploaded.</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
