<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'AI Sales Generator')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }

        .gradient-text {
            background: linear-gradient(135deg, #FF83D6 0%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(255, 131, 214, 0.18);
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.4s ease forwards;
        }

        nav a { transition: background 0.15s, color 0.15s; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen" style="background:#fff9fd;">

    <!-- NAVBAR — dark -->
    <nav class="sticky top-0 z-50" style="background:#1B1B1B; border-bottom: 1.5px solid rgba(255,131,214,0.15);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center overflow-hidden"
                         style="background: #FF83D6;">
                        <img src="{{ asset('icon/s-green-icon.png') }}" alt="Logo" class="w-5 h-5 object-contain">
                    </div>
                    <span class="font-extrabold text-white">SalesAI</span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-1">

                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold"
                       style="{{ request()->routeIs('dashboard')
                           ? 'background:#FF83D6; color:#1B1B1B;'
                           : 'color:rgba(255,255,255,0.6);' }}"
                       @if(!request()->routeIs('dashboard'))
                           onmouseover="this.style.background='rgba(255,131,214,0.15)';this.style.color='#FF83D6';"
                           onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.6)';"
                       @endif>
                        Dashboard
                    </a>

                    <a href="{{ route('sales-pages.create') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold"
                       style="{{ request()->routeIs('sales-pages.create')
                           ? 'background:#FF83D6; color:#1B1B1B;'
                           : 'color:rgba(255,255,255,0.6);' }}"
                       @if(!request()->routeIs('sales-pages.create'))
                           onmouseover="this.style.background='rgba(255,131,214,0.15)';this.style.color='#FF83D6';"
                           onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.6)';"
                       @endif>
                        ✨ Generate
                    </a>

                    <a href="{{ route('sales-pages.index') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold"
                       style="{{ request()->routeIs('sales-pages.index')
                           ? 'background:#FF83D6; color:#1B1B1B;'
                           : 'color:rgba(255,255,255,0.6);' }}"
                       @if(!request()->routeIs('sales-pages.index'))
                           onmouseover="this.style.background='rgba(255,131,214,0.15)';this.style.color='#FF83D6';"
                           onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.6)';"
                       @endif>
                        History
                    </a>

                </div>

                <!-- User + Logout -->
                <div class="flex items-center gap-4 h-full">
                    <span class="text-sm font-extrabold hidden md:block gradient-text">
                        {{ Auth::user()?->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                                class="text-sm font-semibold px-3 py-2 rounded-lg transition-colors"
                                style="color:rgba(255,255,255,0.5);"
                                onmouseover="this.style.color='#ef4444';this.style.background='rgba(239,68,68,0.1)';"
                                onmouseout="this.style.color='rgba(255,255,255,0.5)';this.style.background='';">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="fade-in px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-2"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="fade-in px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-2"
                 style="background:#fff5f5; border:1px solid #fecaca; color:#dc2626;">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
