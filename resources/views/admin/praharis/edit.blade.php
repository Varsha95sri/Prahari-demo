<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl">
            <h1 class="text-2xl font-bold text-slate-950">Edit Prahari</h1>
            <form method="POST" action="{{ route('admin.praharis.update', $prahari) }}" class="mt-6 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                @csrf
                @method('PUT')
                @include('admin.praharis.form', ['prahari' => $prahari])
                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.praharis.index') }}" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Cancel</a>
                    <button class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Update Prahari</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
