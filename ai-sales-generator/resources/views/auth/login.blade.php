<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SalesAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#1B1B1B] min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-[#FF83D6] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-[#FF83D6]/30">
                <svg class="w-6 h-6 text-[#1B1B1B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">SalesAI</h1>
            <p class="text-gray-400 text-sm mt-1">Sign in to your account</p>
        </div>

        <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-white/10 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FF83D6] focus:border-[#FF83D6] transition-all">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-white/10 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FF83D6] focus:border-[#FF83D6] transition-all">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded accent-[#FF83D6]">
                        Remember me
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#FF83D6] hover:text-[#ff6dcf]">Forgot password?</a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-[#FF83D6] hover:bg-[#ff6dcf] text-[#1B1B1B] font-bold py-3 rounded-xl transition-all shadow-lg shadow-[#FF83D6]/30 hover:shadow-[#FF83D6]/50">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#FF83D6] hover:text-[#ff6dcf] font-semibold">Register</a>
            </p>
        </div>
    </div>
</body>
</html>
