<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-950">Forgot Password</h2>
        <p class="mt-1 text-sm text-slate-500">Enter your email. We will send a reset link.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6 grid gap-3">
            <button class="inline-flex w-full justify-center rounded-md bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                {{ __('Email Password Reset Link') }}
            </button>
            <a class="text-center text-sm font-semibold text-slate-600 hover:text-slate-950" href="{{ route('login') }}">Back to login</a>
        </div>
    </form>
</x-guest-layout>
