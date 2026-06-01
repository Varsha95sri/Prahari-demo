<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8"><div class="mx-auto max-w-3xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Generate Challan</h1>
                <p class="text-sm text-slate-500">Create a challan quickly without switching pages.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Back to Dashboard</a>
        </div>
        <form method="POST" action="{{ route('admin.challans.store') }}" class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-xl">
            @csrf
            @include('admin.challans.form', ['challan' => null])
            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"><a href="{{ route('admin.dashboard') }}" class="inline-flex justify-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a><button class="inline-flex justify-center rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Save Challan</button></div>
        </form>
    </div></div>
</x-app-layout>
