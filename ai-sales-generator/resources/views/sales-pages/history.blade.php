@extends('layouts.app')
@section('title', 'History')

@section('content')
<div class="fade-in space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold" style="color:#1B1B1B;">📄 Sales Page History</h1>
            <p class="text-sm mt-1" style="color:#9ca3af;">All your generated sales pages in one place.</p>
        </div>
        <a href="{{ route('sales-pages.create') }}"
           class="inline-flex items-center gap-2 font-bold px-6 py-3 rounded-xl transition-all duration-150 active:translate-y-[2px]"
           style="background:#FF83D6; color:#1B1B1B; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
            </svg>
            Generate New Page
        </a>
    </div>

    <!-- Empty State -->
    @if($pages->count() === 0)
        <div class="bg-white rounded-2xl p-16 text-center border-2 border-dashed"
             style="border-color:#FF83D6; background:#fff9fd;">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:rgba(255,131,214,0.12);">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     style="color:#FF83D6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="font-bold mb-1" style="color:#1B1B1B;">No pages generated yet</p>
            <p class="text-sm mb-6" style="color:#9ca3af;">Your generated sales pages will appear here.</p>
            <a href="{{ route('sales-pages.create') }}"
               class="inline-flex items-center gap-2 font-bold px-6 py-3 rounded-xl transition-all duration-150"
               style="background:#1B1B1B; color:#FF83D6;"
               onmouseover="this.style.background='#FF83D6';this.style.color='#1B1B1B';"
               onmouseout="this.style.background='#1B1B1B';this.style.color='#FF83D6';">
                ✨ Generate First Page
            </a>
        </div>

    @else
        <!-- Search Bar — hanya tampil kalau ada data -->
        <div class="relative max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:#FF83D6;"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Search by product name..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm bg-white transition-all outline-none"
                   style="border: 1.5px solid #f3e8f5; color:#1B1B1B;"
                   onfocus="this.style.borderColor='#FF83D6'; this.style.boxShadow='0 0 0 3px rgba(255,131,214,0.15)';"
                   onblur="this.style.borderColor='#f3e8f5'; this.style.boxShadow='none';">
        </div>

        <!-- Stats Bar -->
        <div class="bg-white rounded-xl px-5 py-3 flex items-center gap-2 text-sm shadow-sm"
             style="border: 1px solid #f3e8f5;">
            <span class="font-extrabold" style="color:#1B1B1B;">{{ $pages->count() }}</span>
            <span style="color:#9ca3af;">pages total</span>
        </div>

        <!-- Cards Grid -->
        <div id="pagesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($pages as $page)
            <div class="page-card card-hover bg-white rounded-xl shadow-sm p-5 flex flex-col justify-between"
                 style="border: 1px solid #f3e8f5;"
                 data-name="{{ strtolower($page->product_name) }}">

                <!-- Top -->
                <div>
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

                    <h3 class="font-extrabold mb-1 truncate text-base" style="color:#1B1B1B;">
                        {{ $page->product_name }}
                    </h3>
                    <p class="text-sm mb-1 line-clamp-2 leading-relaxed" style="color:#6b7280;">
                        {{ $page->headline ?? 'No headline generated.' }}
                    </p>

                    <div class="flex items-center gap-2 mt-2 mb-4">
                        <span class="text-xs" style="color:#9ca3af;">Tone:</span>
                        <span class="text-xs font-semibold capitalize" style="color:#1B1B1B;">{{ $page->tone }}</span>
                        <span style="color:#f3e8f5;">·</span>
                        <span class="text-xs font-extrabold" style="color:#FF83D6;">
                            {{ $page->pricing_label ?? $page->price }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 pt-3 border-t" style="border-color:#f3e8f5;">

                    {{-- View --}}
                    <a href="{{ route('sales-pages.show', $page->id) }}"
                       class="flex-1 flex items-center justify-center text-sm font-bold px-3 py-2 rounded-lg transition-all duration-150"
                       style="background:rgba(255,131,214,0.12); color:#FF83D6;"
                       onmouseover="this.style.background='#FF83D6';this.style.color='#1B1B1B';"
                       onmouseout="this.style.background='rgba(255,131,214,0.12)';this.style.color='#FF83D6';">
                        View
                    </a>

                    {{-- Export --}}
                    <a href="{{ route('sales-pages.export', $page->id) }}"
                       class="flex items-center justify-center gap-1 text-sm font-medium px-3 py-2 rounded-lg transition-colors border"
                       style="color:#6b7280; border-color:#e5e7eb; background:white;"
                       onmouseover="this.style.background='#f9fafb';this.style.color='#1B1B1B';"
                       onmouseout="this.style.background='white';this.style.color='#6b7280';"
                       title="Export HTML">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 424 511.54" fill="currentColor">
                            <path fill-rule="nonzero" d="M86.37 413.44c-11.76 0-11.76-17.89 0-17.89H189.1c-.2 2.95-.31 5.93-.31 8.94s.11 5.99.31 8.95H86.37zm-3.24-147.13V237.1H63.31v29.21H36.88v-82.59h26.43v29.2h19.82v-29.2h26.43v82.59H83.13zm96.46-61.45h-19.16v61.45H134v-61.45h-19.15v-21.14h64.74v21.14zm29.61 61.45h-27.62l5.02-82.59h34.49l10.31 42.02h.92l10.31-42.02h34.48l5.03 82.59h-27.62l-1.59-40.04h-.92l-10.04 40.04h-20.22l-10.18-40.04h-.79l-1.58 40.04zm131.41 0h-52.86v-82.59h26.43v61.44h26.43v21.15zm-74.8-242.05v29.1c0 65.66 15.31 69.47 69.08 69.47h22.03l-91.11-98.57zm94.33 115.92h-21.48c-61.02 0-90.2-4.09-90.2-86.28V17.35H56.82c-21.7 0-39.47 17.78-39.47 39.47v264.79H219.2c-4.64 5.47-8.83 11.34-12.51 17.54H17.35v89.83c0 21.62 17.85 39.47 39.47 39.47h149.04c3.53 6.12 7.56 11.92 12.02 17.34H56.82C25.63 485.79 0 460.17 0 428.98V56.82C0 25.55 25.55 0 56.82 0h206.33a8.68 8.68 0 016.93 3.45l105.07 113.68c2.19 2.37 2.34 4.66 2.34 7.52v166.86c-5.55-2.98-11.35-5.56-17.35-7.71V140.18z"/>
                            <path d="M316.95 297.45c59.12 0 107.05 47.93 107.05 107.05 0 59.11-47.93 107.04-107.05 107.04S209.9 463.61 209.9 404.5c0-59.12 47.93-107.05 107.05-107.05z"/>
                            <path fill-rule="nonzero" d="M337.9 356.54l-3.77 47.75 17.35-6.07c11.47-4.4 23.27 3.72 14.38 13.82-10.82 12.45-27.26 29.55-39.22 40.94-7.43 7.42-11.73 7.49-19.18.06-13.24-13-26.24-27.44-39.18-40.87-9.25-10.06 2.3-18.55 14.28-13.95l17.16 6.01c-1.25-16.28-2.82-31.84-3.77-48.1 0-2.99 2.5-5.39 5.42-5.61 10.31 0 20.84-.24 31.12 0 2.92.22 5.42 2.62 5.42 5.61l-.01.41z"/>
                        </svg>
                        <span class="hidden sm:inline">Export</span>
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('sales-pages.destroy', $page->id) }}" method="POST"
                          onsubmit="return confirm('Delete \'{{ $page->product_name }}\'? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-sm font-medium px-3 py-2 rounded-lg transition-all border"
                                style="color:#ef4444; border-color:#fee2e2; background:#fff5f5;"
                                onmouseover="this.style.background='#ef4444';this.style.color='white';this.style.borderColor='#ef4444';"
                                onmouseout="this.style.background='#fff5f5';this.style.color='#ef4444';this.style.borderColor='#fee2e2';"
                                title="Delete">
                            🗑
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No results after search -->
        <div id="noResults" class="hidden text-center py-12">
            <p class="text-sm" style="color:#9ca3af;">No pages match your search.</p>
        </div>

    @endif

</div>
@endsection

@push('scripts')
<script>
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.page-card');
        let visible = 0;

        cards.forEach(card => {
            const name = card.dataset.name || '';
            const show = !q || name.includes(q);
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        const noResults = document.getElementById('noResults');
        if (noResults) noResults.classList.toggle('hidden', visible > 0);
    });
}
</script>
@endpush
