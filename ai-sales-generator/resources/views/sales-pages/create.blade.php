@extends('layouts.app')
@section('title', 'Generate Sales Page')

@section('content')
<div class="fade-in max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-2xl font-extrabold" style="color:#1B1B1B;">✨ Generate Sales Page</h1>
        <p class="mt-1" style="color:#9ca3af;">Fill in your product details and AI will create a high-converting sales page.</p>
    </div>

    <form id="generateForm" action="{{ route('sales-pages.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 space-y-6"
             style="border: 1px solid #f3e8f5;">

            <!-- Row 1: Product Name + Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                        Product / Service Name <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}"
                           placeholder="e.g. TaskFlow — SaaS for Freelancers"
                           class="w-full px-4 py-3 rounded-xl text-sm transition-all outline-none"
                           style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                           onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                           onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';"
                           required>
                    @error('product_name')
                        <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                        Price <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="price" value="{{ old('price') }}"
                           placeholder="e.g. $29/month or One-time $199"
                           class="w-full px-4 py-3 rounded-xl text-sm transition-all outline-none"
                           style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                           onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                           onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';"
                           required>
                    @error('price')
                        <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                    Product Description <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="description" rows="4"
                          placeholder="e.g. TaskFlow is a project management tool built for freelancers who juggle multiple clients. It simplifies invoicing, task tracking, and client communication in one place."
                          class="w-full px-4 py-3 rounded-xl text-sm transition-all resize-none outline-none"
                          style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                          onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                          onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Features -->
            <div>
                <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                    Key Features <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="features" rows="3"
                          placeholder="e.g. Time tracking, Invoice generation, Client portal, Kanban board, Automated reminders"
                          class="w-full px-4 py-3 rounded-xl text-sm transition-all resize-none outline-none"
                          style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                          onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                          onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';"
                          required>{{ old('features') }}</textarea>
                <p class="text-xs mt-1" style="color:#9ca3af;">Separate features with commas</p>
                @error('features')
                    <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Row 2: Target Audience + USP -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                        Target Audience <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="target_audience" value="{{ old('target_audience') }}"
                           placeholder="e.g. Freelancers, Small business owners"
                           class="w-full px-4 py-3 rounded-xl text-sm transition-all outline-none"
                           style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                           onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                           onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';"
                           required>
                    @error('target_audience')
                        <p class="text-xs mt-1" style="color:#ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                        Unique Selling Points
                    </label>
                    <input type="text" name="usp" value="{{ old('usp') }}"
                           placeholder="e.g. Only tool with built-in client portal"
                           class="w-full px-4 py-3 rounded-xl text-sm transition-all outline-none"
                           style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                           onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                           onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';">
                </div>
            </div>

            <!-- Row 3: Tone + Template -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                        Tone <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="tone"
                            class="w-full px-4 py-3 rounded-xl text-sm transition-all outline-none bg-white"
                            style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                            onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                            onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';">
                        <option value="professional" {{ old('tone') === 'professional' ? 'selected' : '' }}>💼 Professional</option>
                        <option value="friendly"    {{ old('tone') === 'friendly'    ? 'selected' : '' }}>😊 Friendly & Casual</option>
                        <option value="urgent"      {{ old('tone') === 'urgent'      ? 'selected' : '' }}>🔥 Urgent & Bold</option>
                        <option value="luxurious"   {{ old('tone') === 'luxurious'   ? 'selected' : '' }}>💎 Luxurious & Premium</option>
                        <option value="playful"     {{ old('tone') === 'playful'     ? 'selected' : '' }}>🎉 Playful & Fun</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-extrabold mb-2" style="color:#1B1B1B;">
                        Template Style <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="template"
                            class="w-full px-4 py-3 rounded-xl text-sm transition-all outline-none bg-white"
                            style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                            onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                            onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';">
                        <option value="default"    {{ old('template') === 'default'    ? 'selected' : '' }}>🌐 General / Default</option>
                        <option value="saas"       {{ old('template') === 'saas'       ? 'selected' : '' }}>⚙️ SaaS / Software</option>
                        <option value="ecommerce"  {{ old('template') === 'ecommerce'  ? 'selected' : '' }}>🛒 E-Commerce / Product</option>
                    </select>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-2">
                <button type="submit" id="submitBtn"
                        class="w-full md:w-auto flex items-center justify-center gap-2 font-bold px-8 py-4 rounded-xl transition-all duration-150 active:translate-y-[2px] disabled:opacity-60 disabled:cursor-not-allowed"
                        style="background:#FF83D6; color:#1B1B1B; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);"
                        onmouseover="if(!this.disabled){this.style.background='#1B1B1B';this.style.color='#FF83D6';}"
                        onmouseout="if(!this.disabled){this.style.background='#FF83D6';this.style.color='#1B1B1B';}">
                    <svg id="btnIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span id="btnText">🚀 Generate Sales Page</span>
                </button>
                <p class="text-xs mt-3" style="color:#9ca3af;">⏱ AI generation takes 15-30 seconds</p>
            </div>

        </div>
    </form>
</div>

<!-- ══════════════════════════════════════════
     LOADING OVERLAY
══════════════════════════════════════════ -->
<div id="loadingOverlay"
     class="hidden fixed inset-0 backdrop-blur-sm z-50 flex items-center justify-center"
     style="background: rgba(27,27,27,0.65);">
    <div class="bg-white rounded-2xl p-10 text-center max-w-sm mx-4 shadow-2xl"
         style="border: 2px solid rgba(255,131,214,0.25);">

        {{-- Spinner --}}
        <div class="w-16 h-16 rounded-full border-4 mx-auto mb-6 spinner"
             style="border-color: rgba(255,131,214,0.2); border-top-color: #FF83D6;"></div>

        <h3 class="text-xl font-extrabold mb-2" style="color:#1B1B1B;">Generating Your Sales Page</h3>
        <p class="text-sm" style="color:#6b7280;" id="loadingMessage">AI is crafting your headline...</p>

        {{-- Progress bar --}}
        <div class="mt-4">
            <div class="h-1.5 rounded-full overflow-hidden" style="background:#f3e8f5;">
                <div id="progressBar"
                     class="h-full rounded-full transition-all duration-500"
                     style="width: 0%; background: linear-gradient(90deg, #FF83D6, #1B1B1B);"></div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner { animation: spin 1s linear infinite; }
</style>
<script>
const messages = [
    "AI is crafting your headline...",
    "Writing compelling copy...",
    "Building benefits section...",
    "Adding social proof...",
    "Finalizing your sales page...",
];

document.getElementById('generateForm').addEventListener('submit', function(e) {
    const btn         = document.getElementById('submitBtn');
    const overlay     = document.getElementById('loadingOverlay');
    const msgEl       = document.getElementById('loadingMessage');
    const progressBar = document.getElementById('progressBar');

    btn.disabled = true;
    overlay.classList.remove('hidden');

    let i = 0;
    let progress = 0;

    const interval = setInterval(() => {
        if (i < messages.length) {
            msgEl.textContent = messages[i];
            progress = Math.min(progress + 20, 90);
            progressBar.style.width = progress + '%';
            i++;
        } else {
            clearInterval(interval);
        }
    }, 3000);
});
</script>
@endpush
