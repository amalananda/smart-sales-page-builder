<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $salesPage->product_name }} — Sales Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; margin: 0; padding: 0; }
        * { box-sizing: border-box; }
    </style>
</head>
<body style="background:white;">

@php
    $featuresBreakdown = $salesPage->features_breakdown ?? [];
@endphp

<!-- HERO -->
<section style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 50%, #FF83D6 100%); color: white; padding: 80px 24px; text-align: center; position: relative; overflow: hidden;">
    <div style="position:absolute; inset:0; opacity:0.05; background-image: radial-gradient(#FF83D6 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div style="position:absolute; top:-40px; right:-40px; width:280px; height:280px; background:#FF83D6; border-radius:50%; filter:blur(60px); opacity:0.1;"></div>
    <div style="position:absolute; bottom:-40px; left:-40px; width:280px; height:280px; background:#FF83D6; border-radius:50%; filter:blur(60px); opacity:0.1;"></div>
    <div style="max-width: 720px; margin: 0 auto; position: relative; z-index: 1;">
        <div style="display: inline-block; background: rgba(255,131,214,0.15); border: 1px solid rgba(255,131,214,0.35); color: #FF83D6; font-size: 11px; font-weight: 700; padding: 6px 16px; border-radius: 999px; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px;">
            ✦ {{ ucfirst($salesPage->template) }} · {{ ucfirst($salesPage->tone) }}
        </div>
        <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; line-height: 1.15; margin: 0 0 20px; color: white;">
            {{ $salesPage->headline }}
        </h1>
        <p style="font-size: 1.2rem; color: rgba(255,131,214,0.85); margin: 0 0 40px; line-height: 1.6;">
            {{ $salesPage->subheadline }}
        </p>
        <a href="#pricing" style="display: inline-block; background: #FF83D6; color: #1B1B1B; font-weight: 800; font-size: 1.1rem; padding: 16px 36px; border-radius: 12px; text-decoration: none; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
            {{ $salesPage->cta_button }} →
        </a>
        <p style="color: rgba(255,131,214,0.6); font-size: 0.8rem; margin-top: 16px;">No credit card required · Free trial</p>
    </div>
</section>

<!-- PRODUCT DESCRIPTION -->
<section style="background: #fff9fd; padding: 72px 24px;">
    <div style="max-width: 680px; margin: 0 auto; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #1B1B1B; margin: 0 0 24px;">
            What is {{ $salesPage->product_name }}?
        </h2>
        <div style="color: #4b5563; font-size: 1.05rem; line-height: 1.8;">
            @foreach(preg_split('/\r\n|\r|\n/', $salesPage->product_description ?? '') as $para)
                @if(trim($para))
                    <p style="margin: 0 0 16px;">{{ trim($para) }}</p>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- BENEFITS -->
@if($salesPage->benefits && count($salesPage->benefits) > 0)
<section style="background: white; padding: 72px 24px;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="font-size: 2rem; font-weight: 800; color: #1B1B1B; margin: 0 0 12px;">Why Choose {{ $salesPage->product_name }}?</h2>
            <p style="color: #9ca3af; font-size: 1.05rem; margin: 0;">Everything you need to succeed</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            @foreach($salesPage->benefits as $benefit)
            <div style="display: flex; gap: 16px; padding: 24px; background: #fff9fd; border-radius: 16px; border: 1px solid #f3e8f5;">
                <div style="font-size: 2rem; flex-shrink: 0;">{{ $benefit['icon'] ?? '✅' }}</div>
                <div>
                    <h3 style="font-weight: 800; color: #1B1B1B; margin: 0 0 6px; font-size: 1rem;">{{ $benefit['title'] ?? '' }}</h3>
                    <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.6; margin: 0;">{{ $benefit['description'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- FEATURES -->
@if(count($featuresBreakdown) > 0)
<section style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 100%); color: white; padding: 72px 24px;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="font-size: 2rem; font-weight: 800; color: white; margin: 0 0 12px;">Powerful Features</h2>
            <p style="color: rgba(255,131,214,0.7); font-size: 1.05rem; margin: 0;">Everything built in, nothing to add</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            @foreach($featuresBreakdown as $feature)
            <div style="background: rgba(255,131,214,0.08); border: 1px solid rgba(255,131,214,0.2); border-radius: 12px; padding: 24px;">
                <div style="width: 36px; height: 36px; background: rgba(255,131,214,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="18" height="18" fill="none" stroke="#FF83D6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 style="font-weight: 800; color: white; margin: 0 0 8px; font-size: 1rem;">{{ $feature['title'] ?? '' }}</h3>
                <p style="color: rgba(255,131,214,0.7); font-size: 0.875rem; line-height: 1.6; margin: 0;">{{ $feature['description'] ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- TESTIMONIALS -->
@if($salesPage->testimonials && count($salesPage->testimonials) > 0)
<section style="background: #fff9fd; padding: 72px 24px;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="font-size: 2rem; font-weight: 800; color: #1B1B1B; margin: 0 0 12px;">What Customers Say</h2>
            <p style="color: #9ca3af; margin: 0;">Trusted by thousands worldwide</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            @foreach($salesPage->testimonials as $testimonial)
            <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #f3e8f5; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; gap: 2px; margin-bottom: 16px;">
                    @for($i = 0; $i < min((int)($testimonial['rating'] ?? 5), 5); $i++)
                        <svg width="16" height="16" fill="#facc15" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p style="color: #374151; font-size: 0.875rem; line-height: 1.7; margin: 0 0 16px; font-style: italic;">"{{ $testimonial['text'] ?? '' }}"</p>
                <p style="font-weight: 800; color: #1B1B1B; font-size: 0.875rem; margin: 0;">{{ $testimonial['name'] ?? '' }}</p>
                <p style="color: #9ca3af; font-size: 0.75rem; margin: 2px 0 0;">{{ $testimonial['role'] ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- PRICING -->
<section id="pricing" style="background: white; padding: 80px 24px;">
    <div style="max-width: 480px; margin: 0 auto; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #1B1B1B; margin: 0 0 12px;">Simple, Transparent Pricing</h2>
        <p style="color: #9ca3af; margin: 0 0 40px;">No hidden fees. Cancel anytime.</p>
        <div style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 100%); border-radius: 24px; padding: 40px; color: white; box-shadow: 0 25px 50px rgba(0,0,0,0.2);">
            <div style="font-size: 3rem; font-weight: 800; margin: 0 0 8px; color: #FF83D6;">
                {{ $salesPage->pricing_label ?? $salesPage->price }}
            </div>
            <p style="color: rgba(255,131,214,0.7); font-size: 1.1rem; margin: 0 0 32px;">{{ $salesPage->product_name }}</p>
            @if(count($featuresBreakdown) > 0)
            <ul style="text-align: left; list-style: none; padding: 0; margin: 0 0 32px; display: flex; flex-direction: column; gap: 12px;">
                @foreach(array_slice($featuresBreakdown, 0, 5) as $feat)
                <li style="display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.8); font-size: 0.875rem;">
                    <svg width="18" height="18" fill="none" stroke="#FF83D6" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ $feat['title'] ?? '' }}
                </li>
                @endforeach
            </ul>
            @endif
            <a href="#" style="display: block; width: 100%; background: #FF83D6; color: #1B1B1B; font-weight: 800; font-size: 1.1rem; padding: 16px; border-radius: 12px; text-decoration: none; text-align: center; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
                {{ $salesPage->cta_button }} →
            </a>
            <p style="color: rgba(255,131,214,0.6); font-size: 0.75rem; margin: 16px 0 0;">{{ $salesPage->cta_text }}</p>
        </div>
    </div>
</section>

<!-- FINAL CTA -->
<section style="background: linear-gradient(135deg, #1B1B1B 0%, #2d1a28 50%, #FF83D6 100%); padding: 72px 24px; text-align: center;">
    <h2 style="font-size: 2rem; font-weight: 800; color: white; margin: 0 0 24px;">Ready to Get Started?</h2>
    <a href="#" style="display: inline-block; background: #FF83D6; color: #1B1B1B; font-weight: 800; font-size: 1.1rem; padding: 16px 48px; border-radius: 12px; text-decoration: none; box-shadow: 0 6px 0 0 rgba(180,60,140,0.5);">
        {{ $salesPage->cta_button }} →
    </a>
    <p style="color: rgba(255,131,214,0.6); font-size: 0.8rem; margin-top: 16px;">Generated by SalesAI · {{ now()->format('Y') }}</p>
</section>

</body>
</html>
