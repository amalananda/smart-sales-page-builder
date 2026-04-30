@extends('layouts.app')
@section('title', $salesPage->product_name)

@php
    $featuresBreakdown = $salesPage->features_breakdown ?? [];
@endphp

@section('content')

<!-- Action Bar -->
<div class="fade-in flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <a href="{{ route('sales-pages.index') }}"
           class="text-sm font-medium transition-colors"
           style="color:#9ca3af;"
           onmouseover="this.style.color='#1B1B1B';"
           onmouseout="this.style.color='#9ca3af';">
            ← History
        </a>
        <h1 class="text-xl font-extrabold mt-1" style="color:#1B1B1B;">{{ $salesPage->product_name }}</h1>
        <p class="text-sm" style="color:#9ca3af;">Generated {{ $salesPage->created_at->format('M d, Y · h:i A') }}</p>
    </div>

    <div class="flex flex-wrap gap-2">

        {{-- Regenerate --}}
        <form id="regenerateForm"
              action="{{ route('sales-pages.regenerate', $salesPage->id) }}"
              method="POST">
            @csrf
            <button type="submit" id="regenerateBtn"
                    class="flex items-center gap-2 font-semibold px-4 py-2 rounded-xl text-sm transition-all duration-150"
                    style="background:rgba(255,131,214,0.12); color:#FF83D6; border:1px solid rgba(255,131,214,0.3);"
                    onmouseover="this.style.background='#FF83D6';this.style.color='#1B1B1B';"
                    onmouseout="this.style.background='rgba(255,131,214,0.12)';this.style.color='#FF83D6';">
                🔄 Regenerate
            </button>
        </form>

        {{-- Export HTML --}}
        <a href="{{ route('sales-pages.export', $salesPage->id) }}"
           class="flex items-center gap-2 font-semibold px-4 py-2 rounded-xl text-sm transition-all duration-150"
           style="background:white; color:#6b7280; border:1px solid #e5e7eb;"
           onmouseover="this.style.background='#f9fafb';this.style.color='#1B1B1B';"
           onmouseout="this.style.background='white';this.style.color='#6b7280';">
            📥 Export HTML
        </a>

        {{-- New Page --}}
        <a href="{{ route('sales-pages.create') }}"
           class="flex items-center gap-2 font-bold px-4 py-2 rounded-xl text-sm transition-all duration-150"
           style="background:#1B1B1B; color:#FF83D6;"
           onmouseover="this.style.background='#FF83D6';this.style.color='#1B1B1B';"
           onmouseout="this.style.background='#1B1B1B';this.style.color='#FF83D6';">
            + New Page
        </a>

    </div>
</div>

<!-- SALES PAGE PREVIEW -->
<div class="bg-white rounded-2xl overflow-hidden shadow-xl fade-in"
     style="border: 1px solid #f3e8f5;">

    <!-- HERO SECTION -->
    <div class="text-white px-6 py-20 text-center relative overflow-hidden"
         style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 50%, #FF83D6 100%);">
        <div class="absolute inset-0 opacity-5"
             style="background-image: radial-gradient(#FF83D6 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute -top-10 -right-10 w-72 h-72 rounded-full opacity-10"
             style="background:#FF83D6; filter:blur(60px);"></div>
        <div class="absolute -bottom-10 -left-10 w-72 h-72 rounded-full opacity-10"
             style="background:#FF83D6; filter:blur(60px);"></div>

        <div class="relative max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2 rounded-full mb-6 uppercase tracking-wider border"
                 style="background:rgba(255,131,214,0.15); border-color:rgba(255,131,214,0.35); color:#FF83D6;">
                ✦ {{ ucfirst($salesPage->template) }} · {{ ucfirst($salesPage->tone) }}
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-white">
                {{ $salesPage->headline }}
            </h1>
            <p class="text-xl mb-10 leading-relaxed" style="color:rgba(255,131,214,0.85);">
                {{ $salesPage->subheadline }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#pricing"
                   class="font-bold px-8 py-4 rounded-xl text-lg transition-all duration-150"
                   style="background:#FF83D6; color:#1B1B1B; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
                    {{ $salesPage->cta_button }} →
                </a>
                <span class="text-sm" style="color:rgba(255,131,214,0.7);">No credit card required · Free trial</span>
            </div>
        </div>
    </div>

    <!-- PRODUCT DESCRIPTION -->
    <div class="px-6 py-16" style="background:#fff9fd;">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold mb-6" style="color:#1B1B1B;">
                What is {{ $salesPage->product_name }}?
            </h2>
            <div class="text-lg leading-relaxed space-y-4" style="color:#4b5563;">
                @foreach(preg_split('/\r\n|\r|\n/', $salesPage->product_description ?? '') as $para)
                    @if(trim($para))
                        <p>{{ trim($para) }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- BENEFITS -->
    @if($salesPage->benefits && count($salesPage->benefits) > 0)
    <div class="px-6 py-16 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold mb-3" style="color:#1B1B1B;">
                    Why Choose {{ $salesPage->product_name }}?
                </h2>
                <p class="text-lg" style="color:#9ca3af;">Everything you need to succeed</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($salesPage->benefits as $benefit)
                <div class="flex gap-4 p-6 rounded-2xl transition-all duration-150 border"
                     style="background:#fff9fd; border-color:#f3e8f5;"
                     onmouseover="this.style.background='rgba(255,131,214,0.08)';this.style.borderColor='rgba(255,131,214,0.3)';"
                     onmouseout="this.style.background='#fff9fd';this.style.borderColor='#f3e8f5';">
                    <div class="text-3xl flex-shrink-0">{{ $benefit['icon'] ?? '✅' }}</div>
                    <div>
                        <h3 class="font-extrabold mb-1" style="color:#1B1B1B;">{{ $benefit['title'] ?? '' }}</h3>
                        <p class="text-sm leading-relaxed" style="color:#6b7280;">{{ $benefit['description'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- FEATURES -->
    @if(count($featuresBreakdown) > 0)
    <div class="px-6 py-16 text-white"
         style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 100%);">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold mb-3 text-white">Powerful Features</h2>
                <p class="text-lg" style="color:rgba(255,131,214,0.7);">Everything built in, nothing to add</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuresBreakdown as $feature)
                <div class="rounded-xl p-6 border"
                     style="background:rgba(255,131,214,0.08); border-color:rgba(255,131,214,0.2);">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-4"
                         style="background:rgba(255,131,214,0.2);">
                        <svg class="w-5 h-5" fill="none" stroke="#FF83D6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="font-extrabold mb-2 text-white">{{ $feature['title'] ?? '' }}</h3>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,131,214,0.7);">{{ $feature['description'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- TESTIMONIALS -->
    @if($salesPage->testimonials && count($salesPage->testimonials) > 0)
    <div class="px-6 py-16" style="background:#fff9fd;">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold mb-3" style="color:#1B1B1B;">What Customers Say</h2>
                <p style="color:#9ca3af;">Trusted by thousands worldwide</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($salesPage->testimonials as $testimonial)
                <div class="bg-white rounded-2xl p-6 shadow-sm border"
                     style="border-color:#f3e8f5;">
                    <div class="flex gap-0.5 mb-4">
                        @for($i = 0; $i < min((int)($testimonial['rating'] ?? 5), 5); $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-sm leading-relaxed mb-4 italic" style="color:#4b5563;">"{{ $testimonial['text'] ?? '' }}"</p>
                    <p class="font-extrabold text-sm" style="color:#1B1B1B;">{{ $testimonial['name'] ?? '' }}</p>
                    <p class="text-xs mt-0.5" style="color:#9ca3af;">{{ $testimonial['role'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- PRICING -->
    <div id="pricing" class="px-6 py-20 bg-white">
        <div class="max-w-lg mx-auto text-center">
            <h2 class="text-3xl font-extrabold mb-3" style="color:#1B1B1B;">Simple, Transparent Pricing</h2>
            <p class="mb-10" style="color:#9ca3af;">No hidden fees. Cancel anytime.</p>

            <div class="rounded-3xl p-8 text-white shadow-2xl"
                 style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 100%);">
                <div class="text-5xl font-extrabold mb-2" style="color:#FF83D6;">
                    {{ $salesPage->pricing_label ?? $salesPage->price }}
                </div>
                <p class="mb-8 text-lg" style="color:rgba(255,131,214,0.7);">{{ $salesPage->product_name }}</p>

                @if(count($featuresBreakdown) > 0)
                <ul class="text-left space-y-3 mb-8">
                    @foreach(array_slice($featuresBreakdown, 0, 5) as $feat)
                        <li class="flex items-center gap-3 text-sm" style="color:rgba(255,255,255,0.8);">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="#FF83D6" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feat['title'] ?? '' }}
                        </li>
                    @endforeach
                </ul>
                @endif

                <a href="#"
                   class="block w-full font-extrabold py-4 rounded-xl text-lg transition-all duration-150"
                   style="background:#FF83D6; color:#1B1B1B; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
                    {{ $salesPage->cta_button }} →
                </a>
                <p class="text-xs mt-4" style="color:rgba(255,131,214,0.6);">{{ $salesPage->cta_text }}</p>
            </div>
        </div>
    </div>

    <!-- FINAL CTA -->
    <div class="px-6 py-16 text-center text-white"
         style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 50%, #FF83D6 100%);">
        <h2 class="text-3xl font-extrabold mb-4 text-white">Ready to Get Started?</h2>
        <a href="#"
           class="inline-block font-extrabold px-10 py-4 rounded-xl text-lg transition-all duration-150"
           style="background:#FF83D6; color:#1B1B1B; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
            {{ $salesPage->cta_button }} →
        </a>
    </div>

</div>

<!-- Loading Overlay Regenerate -->
<div id="regenerateOverlay"
     class="hidden fixed inset-0 backdrop-blur-sm z-50 flex items-center justify-center"
     style="background:rgba(27,27,27,0.7);">
    <div class="bg-white rounded-2xl p-10 text-center max-w-sm mx-4 shadow-2xl"
         style="border: 2px solid rgba(255,131,214,0.25);">
        <div class="w-16 h-16 rounded-full border-4 mx-auto mb-6 spinner"
             style="border-color:rgba(255,131,214,0.2); border-top-color:#FF83D6;"></div>
        <h3 class="text-xl font-extrabold mb-2" style="color:#1B1B1B;">Regenerating Sales Page</h3>
        <p class="text-sm" style="color:#6b7280;" id="regenerateMessage">AI is rewriting your headline...</p>
        <div class="mt-4">
            <div class="h-1.5 rounded-full overflow-hidden" style="background:#f3e8f5;">
                <div id="regenerateProgress"
                     class="h-full rounded-full transition-all duration-500"
                     style="width:0%; background:linear-gradient(90deg, #FF83D6, #1B1B1B);"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner { animation: spin 1s linear infinite; }
</style>
<script>
const regenMessages = [
    "AI is rewriting your headline...",
    "Crafting new copy...",
    "Building benefits section...",
    "Adding social proof...",
    "Finalizing your page...",
];

document.getElementById('regenerateForm').addEventListener('submit', function() {
    const overlay  = document.getElementById('regenerateOverlay');
    const msgEl    = document.getElementById('regenerateMessage');
    const progress = document.getElementById('regenerateProgress');
    const btn      = document.getElementById('regenerateBtn');

    btn.disabled = true;
    overlay.classList.remove('hidden');

    let i = 0, pct = 0;
    const interval = setInterval(() => {
        if (i < regenMessages.length) {
            msgEl.textContent = regenMessages[i];
            pct = Math.min(pct + 20, 90);
            progress.style.width = pct + '%';
            i++;
        } else {
            clearInterval(interval);
        }
    }, 3000);
});
</script>
@endpush
@endsection
