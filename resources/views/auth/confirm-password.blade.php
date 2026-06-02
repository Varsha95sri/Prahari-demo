<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Password - {{ config('app.name', 'Prahari') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; color: #ffffff; overflow: auto; padding: 2rem 0; }
        .glass-container { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 3rem; width: 100%; max-width: 450px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); animation: fadeIn 0.8s ease-out forwards; }
        p.subtitle { color: #94a3b8; font-size: 0.95rem; margin: 0 0 2rem 0; text-align: center; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #e2e8f0; }
        input[type="password"] { width: 100%; padding: 0.75rem 1rem; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; color: white; font-family: 'Inter', sans-serif; font-size: 1rem; box-sizing: border-box; transition: all 0.2s ease; }
        input[type="password"]:focus { outline: none; border-color: #3b82f6; background: rgba(255, 255, 255, 0.1); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3); }
        .btn-primary { width: 100%; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 600; font-size: 1rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3); transition: all 0.2s ease; margin-top: 1rem; }
        .btn-primary:hover { background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4); transform: translateY(-2px); }
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block; }
        .background-blob { position: fixed; border-radius: 50%; filter: blur(100px); z-index: -1; }
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: rgba(59, 130, 246, 0.3); }
        .blob-2 { bottom: -20%; right: -10%; width: 600px; height: 600px; background: rgba(139, 92, 246, 0.2); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        ul { margin: 0.5rem 0 0 0; padding-left: 1.5rem; color: #ef4444; font-size: 0.875rem; }
        .text-red-600 { color: #ef4444 !important; }
    </style>
</head>
<body>
    <div class="background-blob blob-1"></div>
    <div class="background-blob blob-2"></div>

    <div class="glass-container">
        <p class="subtitle">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="error-message" />
            </div>

            <button type="submit" class="btn-primary">
                {{ __('Confirm') }}
            </button>
        </form>
    </div>
</body>
</html>
