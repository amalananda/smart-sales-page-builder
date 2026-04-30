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

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .slide-down {
            animation: slideDown 0.2s ease forwards;
        }

        nav a { transition: background 0.15s, color 0.15s; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen" style="background:#fff9fd;">

    <!-- ══════════════════════════════════════════
         NAVBAR — dark
    ══════════════════════════════════════════ -->
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

                <!-- Nav Links — desktop only -->
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

                <!-- Right side: user + logout (desktop) + hamburger (mobile) -->
                <div class="flex items-center gap-3">

                    {{-- Username — hidden on mobile --}}
                    <span class="text-sm font-extrabold hidden md:block gradient-text">
                        {{ Auth::user()?->name }}
                    </span>

                    {{-- Logout — hidden on mobile (ada di mobile menu) --}}
                    <form method="POST" action="{{ route('logout') }}" class="m-0 hidden md:block">
                        @csrf
                        <button type="submit"
                                class="text-sm font-semibold px-3 py-2 rounded-lg transition-colors"
                                style="color:rgba(255,255,255,0.5);"
                                onmouseover="this.style.color='#ef4444';this.style.background='rgba(239,68,68,0.1)';"
                                onmouseout="this.style.color='rgba(255,255,255,0.5)';this.style.background='';">
                            Logout
                        </button>
                    </form>

                    {{-- Hamburger button — mobile only --}}
                    <button id="mobileMenuBtn"
                            class="md:hidden flex flex-col justify-center items-center w-9 h-9 rounded-lg gap-1.5 transition-colors"
                            style="color:rgba(255,255,255,0.7);"
                            onmouseover="this.style.background='rgba(255,131,214,0.15)';"
                            onmouseout="this.style.background='';"
                            aria-label="Toggle menu">
                        <span id="bar1" class="block w-5 h-0.5 rounded-full transition-all duration-300"
                              style="background:#FF83D6;"></span>
                        <span id="bar2" class="block w-5 h-0.5 rounded-full transition-all duration-300"
                              style="background:#FF83D6;"></span>
                        <span id="bar3" class="block w-5 h-0.5 rounded-full transition-all duration-300"
                              style="background:#FF83D6;"></span>
                    </button>

                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════
             MOBILE MENU DROPDOWN
        ══════════════════════════════════════ -->
        <div id="mobileMenu"
             class="hidden md:hidden slide-down"
             style="background:#1B1B1B; border-top:1px solid rgba(255,131,214,0.12);">
            <div class="max-w-7xl mx-auto px-4 py-3 space-y-1">

                {{-- User info --}}
                <div class="px-3 py-2 mb-2 rounded-lg flex items-center gap-3"
                     style="background:rgba(255,131,214,0.08);">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background:#FF83D6;">
                        <span class="text-xs font-extrabold" style="color:#1B1B1B;">
                            {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-sm font-extrabold gradient-text">
                        {{ Auth::user()?->name }}
                    </span>
                </div>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold w-full"
                   style="{{ request()->routeIs('dashboard')
                       ? 'background:#FF83D6; color:#1B1B1B;'
                       : 'color:rgba(255,255,255,0.7);' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Generate --}}
                <a href="{{ route('sales-pages.create') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold w-full"
                   style="{{ request()->routeIs('sales-pages.create')
                       ? 'background:#FF83D6; color:#1B1B1B;'
                       : 'color:rgba(255,255,255,0.7);' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    ✨ Generate
                </a>

                {{-- History --}}
                <a href="{{ route('sales-pages.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold w-full"
                   style="{{ request()->routeIs('sales-pages.index')
                       ? 'background:#FF83D6; color:#1B1B1B;'
                       : 'color:rgba(255,255,255,0.7);' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    History
                </a>

                {{-- Divider --}}
                <div class="my-2" style="border-top:1px solid rgba(255,131,214,0.12);"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold w-full transition-colors"
                            style="color:#ef4444;"
                            onmouseover="this.style.background='rgba(239,68,68,0.1)';"
                            onmouseout="this.style.background='';">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>


    <!-- ══════════════════════════════════════════
         FLASH MESSAGES
    ══════════════════════════════════════════ -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="fade-in px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-2"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="fade-in px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-2"
                 style="background:#fff5f5; border:1px solid #fecaca; color:#dc2626;">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                          clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>


    <!-- ══════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════ -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @stack('scripts')

    <!-- ══════════════════════════════════════════
         HAMBURGER TOGGLE SCRIPT
    ══════════════════════════════════════════ -->
    <script>
        const btn     = document.getElementById('mobileMenuBtn');
        const menu    = document.getElementById('mobileMenu');
        const bar1    = document.getElementById('bar1');
        const bar2    = document.getElementById('bar2');
        const bar3    = document.getElementById('bar3');
        let   isOpen  = false;

        btn.addEventListener('click', () => {
            isOpen = !isOpen;

            if (isOpen) {
                // Show menu
                menu.classList.remove('hidden');
                // Animate bars → X
                bar1.style.transform = 'translateY(8px) rotate(45deg)';
                bar2.style.opacity   = '0';
                bar3.style.transform = 'translateY(-8px) rotate(-45deg)';
            } else {
                // Hide menu
                menu.classList.add('hidden');
                // Reset bars
                bar1.style.transform = '';
                bar2.style.opacity   = '1';
                bar3.style.transform = '';
            }
        });

        // Close mobile menu when a nav link is clicked
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                bar1.style.transform = '';
                bar2.style.opacity   = '1';
                bar3.style.transform = '';
                isOpen = false;
            });
        });
    </script>

</body>
</html>
