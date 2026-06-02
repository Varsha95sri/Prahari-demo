<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal - {{ config('app.name', 'Prahari') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            overflow: hidden;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 4rem;
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .glass-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
        }
        .logo-container {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem auto;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5);
        }
        .logo-container svg {
            width: 40px;
            height: 40px;
            color: white;
        }
        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.025em;
        }
        p {
            color: #94a3b8;
            font-size: 1.1rem;
            margin: 0 0 3rem 0;
        }
        .btn {
            display: inline-block;
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .background-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
        }
        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(59, 130, 246, 0.3);
        }
        .blob-2 {
            bottom: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(139, 92, 246, 0.2);
        }
    </style>
</head>
<body>
    <div class="background-blob blob-1"></div>
    <div class="background-blob blob-2"></div>

    <div class="glass-container" style="animation: fadeIn 0.8s ease-out forwards;">
        <div class="logo-container" style="transform: scale(1); animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.3s both;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
        </div>
        
        <h1 style="animation: slideUp 0.5s ease-out 0.4s both;">Admin Portal</h1>
        <p style="animation: slideUp 0.5s ease-out 0.5s both;">Secure access to the management dashboard</p>

        @if (Route::has('login'))
            <div style="display: flex; flex-direction: column; gap: 0.5rem; animation: slideUp 0.5s ease-out 0.6s both;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        Enter Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Sign In to Dashboard
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary" style="margin-top: 10px;">
                            Create Administrator Account
                        </a>
                    @endif
                @endauth
            </div>
        @endif
        
        <div style="margin-top: 2.5rem; font-size: 0.875rem; color: #64748b; animation: slideUp 0.5s ease-out 0.7s both;">
            &copy; {{ date('Y') }} {{ config('app.name', 'Prahari') }}. All rights reserved.
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
