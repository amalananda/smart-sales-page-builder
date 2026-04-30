@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="fade-in space-y-8">

    <!-- ══════════════════════════════════════════
         HERO BANNER
    ══════════════════════════════════════════ -->
    <div class="relative overflow-hidden rounded-2xl p-8 text-white"
         style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 50%, #FF83D6 100%);">

        {{-- Decorative blobs --}}
        <div class="absolute -top-10 -right-10 w-56 h-56 rounded-full opacity-10"
             style="background: #FF83D6; filter: blur(40px);"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full opacity-10"
             style="background: #FF83D6; filter: blur(32px);"></div>

        {{-- Dot pattern overlay --}}
        <div class="absolute inset-0 opacity-5"
             style="background-image: radial-gradient(#FF83D6 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="relative z-10">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold mb-5 border"
                 style="background: rgba(255,131,214,0.15); border-color: rgba(255,131,214,0.35); color: #FF83D6;">
                <span class="w-2 h-2 rounded-full animate-pulse" style="background:#FF83D6;"></span>
                AI-Powered
            </div>

            {{-- Heading --}}
            <h1 class="text-3xl font-extrabold mb-2 leading-tight">
                Generate
                <span class="relative inline-block">
                    High-Converting
                    <span class="absolute left-0 bottom-0 w-full h-[3px] origin-left animate-underline"
                          style="background:#FF83D6;"></span>
                </span><br>
                Sales Pages with AI
            </h1>

            <p class="mb-7 max-w-md text-sm leading-relaxed" style="color: rgba(255,131,214,0.8);">
                Turn your product info into a professional sales page in seconds. No design skills needed.
            </p>

            {{-- CTA Button --}}
            <a href="{{ route('sales-pages.create') }}"
               class="inline-flex items-center gap-2 font-bold px-6 py-3 rounded-xl transition-all duration-150
                      active:translate-y-[2px]"
               style="background:#FF83D6; color:#1B1B1B;
                      box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                </svg>
                Generate New Page
            </a>
        </div>
    </div>


    <!-- ══════════════════════════════════════════
         STATS CARDS
    ══════════════════════════════════════════ -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Total Pages --}}
        <div class="bg-white rounded-xl p-6 border shadow-sm flex items-center gap-4"
             style="border-color: #f3e8f5;">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg, #FF83D6, #1B1B1B);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium" style="color:#9ca3af;">Total Pages Generated</p>
                <p class="text-3xl font-extrabold mt-0.5" style="color:#1B1B1B;">{{ $totalPages }}</p>
            </div>
        </div>

        {{-- This Month --}}
        <div class="bg-white rounded-xl p-6 border shadow-sm flex items-center gap-4"
             style="border-color: #f3e8f5;">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg, #FF83D6, #1B1B1B);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium" style="color:#9ca3af;">This Month</p>
                <p class="text-3xl font-extrabold mt-0.5" style="color:#1B1B1B;">{{ $monthlyPages }}</p>
            </div>
        </div>

        {{-- Account --}}
        <div class="bg-white rounded-xl p-6 border shadow-sm flex items-center gap-4"
             style="border-color: #f3e8f5;">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg, #FF83D6, #1B1B1B);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium" style="color:#9ca3af;">Account</p>
                <p class="text-base font-extrabold leading-tight mt-0.5" style="color:#1B1B1B;">{{ Auth::user()?->name }}</p>
                <p class="text-xs mt-0.5" style="color:#9ca3af;">{{ Auth::user()->email }}</p>
            </div>
        </div>

    </div>


    <!-- ══════════════════════════════════════════
         RECENT PAGES
    ══════════════════════════════════════════ -->
    <div>
        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold" style="color:#1B1B1B;">Recent Pages</h2>
            @if($recentPages->count() > 0)
                <a href="{{ route('sales-pages.index') }}"
                   class="text-sm font-semibold transition-colors hover:underline"
                   style="color:#FF83D6;">
                    View All →
                </a>
            @endif
        </div>

        {{-- Empty State --}}
        @if($recentPages->count() === 0)
            <div class="bg-white rounded-2xl p-12 text-center border-2 border-dashed"
                 style="border-color: #FF83D6; background: #fff9fd;">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                     style="background: rgba(255,131,214,0.12);">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         style="color:#FF83D6;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="font-bold mb-1" style="color:#1B1B1B;">No sales pages yet</p>
                <p class="text-sm mb-6" style="color:#9ca3af;">Generate your first AI-powered sales page</p>
                <a href="{{ route('sales-pages.create') }}"
                   class="inline-flex items-center gap-2 font-bold px-6 py-3 rounded-xl transition-all duration-150"
                   style="background:#1B1B1B; color:#FF83D6;">
                    ✨ Generate First Page
                </a>
            </div>

        {{-- Pages Grid --}}
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($recentPages as $page)

                    {{-- Card --}}
                    <div class="card-hover bg-white rounded-xl border shadow-sm p-5 flex flex-col"
                         style="border-color: #f3e8f5;">

                        {{-- Card Top Row --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                                 style="background: linear-gradient(135deg, #FF83D6, #1B1B1B);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <span class="text-xs" style="color:#9ca3af;">
                                {{ $page->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Product Name --}}
                        <h3 class="font-extrabold mb-1 truncate" style="color:#1B1B1B;">
                            {{ $page->product_name }}
                        </h3>

                        {{-- Headline Preview --}}
                        <p class="text-sm mb-4 line-clamp-2 leading-relaxed flex-1" style="color:#6b7280;">
                            {{ $page->headline ?? '—' }}
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex gap-2 pt-3 border-t" style="border-color:#f3e8f5;">
                            <a href="{{ route('sales-pages.show', $page->id) }}"
                               class="flex-1 flex items-center justify-center text-sm font-bold px-3 py-2 rounded-lg transition-all duration-150"
                               style="background: rgba(255,131,214,0.12); color:#FF83D6;"
                               onmouseover="this.style.background='#FF83D6';this.style.color='#1B1B1B';"
                               onmouseout="this.style.background='rgba(255,131,214,0.12)';this.style.color='#FF83D6';">
                                View
                            </a>
                            <form action="{{ route('sales-pages.destroy', $page->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this page?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-sm font-semibold px-3 py-2 rounded-lg transition-all duration-150 border"
                                        style="color:#ef4444; border-color:#fee2e2; background:#fff5f5;"
                                        onmouseover="this.style.background='#ef4444';this.style.color='white';this.style.borderColor='#ef4444';"
                                        onmouseout="this.style.background='#fff5f5';this.style.color='#ef4444';this.style.borderColor='#fee2e2';">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

{{-- ══════════════════════════════════════
     Underline animation (hero heading)
══════════════════════════════════════ --}}
<style>
@keyframes underline {
    0%   { transform: scaleX(0); opacity: 0; }
    20%  { opacity: 1; }
    50%  { transform: scaleX(1); }
    80%  { opacity: 1; }
    100% { transform: scaleX(0); opacity: 0; }
}
.animate-underline {
    animation: underline 3s ease-in-out infinite;
}
</style>
