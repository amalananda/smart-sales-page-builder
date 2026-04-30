<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SalesPageController extends Controller
{
    public function index()
    {
        $pages = SalesPage::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('sales-pages.history', compact('pages'));
    }

    public function create()
    {
        return view('sales-pages.create');
    }

    public function store(Request $request)
    {
        set_time_limit(120);
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'target_audience' => 'required|string',
            'price' => 'required|string',
            'usp' => 'nullable|string',
            'tone' => 'required|in:professional,friendly,urgent,luxurious,playful',
            'template' => 'required|in:default,saas,ecommerce',
        ]);

        // build AI prompt
        $prompt = $this->buildPrompt($validated);

        // Call OpenRouter AI
        $generated = $this->callOpenRouter($prompt);
        if (!$generated) {
            return back()->withInput()->with('error', 'AI generation failed. Please try again.');
        }

        $salesPage = SalesPage::create([
            'user_id' => Auth::id(),
            'product_name' => $validated['product_name'],
            'description' => $validated['description'],
            'features' => $validated['features'] ?? null,
            'target_audience' => $validated['target_audience'] ?? null,
            'price' => $validated['price'] ?? null,
            'usp' => $validated['usp'] ?? null,
            'tone' => $validated['tone'],
            'template' => $validated['template'],
            'headline' => $generated['headline'] ?? null,
            'subheadline' => $generated['subheadline'] ?? null,
            'product_description' => $generated['product_description'] ?? null,
            'benefits' => $generated['benefits'] ?? [],
            'features_breakdown' => $generated['features_breakdown'] ?? [],
            'testimonials' => $generated['testimonials'] ?? [],
            'cta_text' => $generated['cta_text'] ?? null,
            'cta_button' => $generated['cta_button'] ?? 'Get Started Now',
            'pricing_label' => $generated['pricing_label'] ?? $validated['price'],
            'raw_generated' => $generated,
        ]);
        return redirect()->route('sales-pages.show', $salesPage->id)
            ->with('success', 'Sales page generated successfully!');
    }

    public function show(SalesPage $salesPage)
    {
        if($salesPage->user_id !== Auth::id()){
            abort(403);
        }
        return view('sales-pages.show', compact('salesPage'));
    }

    public function destroy(SalesPage $salesPage)
    {
        if($salesPage->user_id !== Auth::id()){
            abort(403);
        }
        $salesPage->delete();
        return redirect()->route('sales-pages.index')
            ->with('success', 'Sales page deleted');
    }

    public function regenerate(SalesPage $salesPage)
    {
        set_time_limit(120);
        if($salesPage->user_id !== Auth::id()){
            abort(403);
        }
        $data = [
            'product_name' => $salesPage->product_name,
            'description' => $salesPage->description,
            'features' => $salesPage->features,
            'target_audience' => $salesPage->target_audience,
            'price' => $salesPage->price,
            'usp' => $salesPage->usp,
            'tone' => $salesPage->tone,
            'template' => $salesPage->template,
        ];

        $prompt = $this->buildPrompt($data);
        $generated = $this->callOpenRouter($prompt);
        if (!$generated) {
            return back()->with('error', 'Regeneration failed. Please try again.');
        }

        $salesPage->update([
            'headline' => $generated['headline'] ?? $salesPage->headline,
            'subheadline' => $generated['subheadline'] ?? $salesPage->subheadline,
            'product_description' => $generated['product_description'] ?? $salesPage->product_description,
            'benefits' => $generated['benefits'] ?? $salesPage->benefits,
            'features_breakdown' => $generated['features_breakdown'] ?? $salesPage->features_breakdown,
            'testimonials' => $generated['testimonials'] ?? $salesPage->testimonials,
            'cta_text' => $generated['cta_text'] ?? $salesPage->cta_text,
            'cta_button' => $generated['cta_button'] ?? $salesPage->cta_button,
            'pricing_label' => $generated['pricing_label'] ?? $salesPage->pricing_label,
            'raw_generated' => $generated,
        ]);

        return redirect()->route('sales-pages.show', $salesPage->id)
            ->with('success', 'Sales page regenerated!');
    }

    public function exportHtml(SalesPage $salesPage)
    {
        if($salesPage->user_id !== Auth::id()){
            abort(403);
        }
        $html = view('sales-pages.export-html', compact('salesPage'))->render();
        $filename = Str::slug($salesPage->product_name) . '-sales-page.html';

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    // PRIVATE HELPERS
    private function buildPrompt(array $data): string
    {
        $features = $data['features'] ?? 'Not Specified';
        $audience = $data['target_audience'] ?? 'General Audience';
        $price = $data['price'] ?? 'Contact for pricing';
        $usp = $data['usp'] ?? 'Not Specified';
        $tone = $data['tone'] ?? 'professional';
        $template = $data['template'] ?? 'default';

        return <<<PROMPT
You are an expert copywriter and sales page creator. Generate a complete, high-converting sales page for the following product.

PRODUCT DETAILS:
- Product Name: {$data['product_name']}
- Description: {$data['description']}
- Key Features: {$features}
- Target Audience: {$audience}
- Price: {$price}
- Unique Selling Points: {$usp}
- Tone: {$tone}
- Template Type: {$template}

Respond ONLY with a valid JSON object. No markdown. No backticks. No explanation. Just pure raw JSON.

{
  "headline": "Main compelling headline (max 15 words)",
  "subheadline": "Supporting headline that adds context (max 25 words)",
  "product_description": "2-3 paragraph compelling product description",
  "benefits": [
    {"icon": "⚡", "title": "Benefit Title", "description": "Benefit description 1-2 sentences"},
    {"icon": "🎯", "title": "Benefit Title", "description": "Benefit description"},
    {"icon": "🚀", "title": "Benefit Title", "description": "Benefit description"},
    {"icon": "💎", "title": "Benefit Title", "description": "Benefit description"}
  ],
  "features_breakdown": [
    {"title": "Feature Name", "description": "What this feature does and why it matters"},
    {"title": "Feature Name", "description": "Feature description"},
    {"title": "Feature Name", "description": "Feature description"}
  ],
  "testimonials": [
    {"name": "Sarah M.", "role": "CEO, TechStartup", "text": "Compelling testimonial quote", "rating": 5},
    {"name": "John D.", "role": "Freelance Designer", "text": "Another testimonial", "rating": 5},
    {"name": "Lisa K.", "role": "Marketing Manager", "text": "Third testimonial", "rating": 5}
  ],
  "pricing_label": "Price display text e.g. $99/month or One-time $299",
  "cta_text": "Short persuasive text above the CTA button (1 sentence)",
  "cta_button": "CTA button text (3-5 words)"
}
PROMPT;
    }

    private function callOpenRouter(string $prompt): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
                'HTTP-Referer' => env('APP_URL', 'http://localhost'),
                'X-Title'       => env('APP_NAME', 'SalesAI'),
            ])
            ->timeout(60)
            ->post(
                env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1') . '/chat/completions',
                [
                    'model'    => env('OPENROUTER_MODEL', 'openai/gpt-oss-120b:free'),
                    'messages' => [
                        [
                            'role'    => 'system',
                            'content' => 'You are an expert sales copywriter. You must return ONLY valid JSON. No markdown. No backticks. No explanation. Just raw JSON.',
                        ],
                        [
                            'role'    => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.7,
                    'max_tokens'  => 1500,
                ]
            );

            if ($response->failed()) {
                Log::error('OpenRouter API failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }
            $body    = $response->json();
            $content = $body['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                Log::error('OpenRouter empty content', ['body' => $body]);
                return null;
            }
            // Clean up content to ensure it's valid JSON
            $content = trim($content);
            $content = preg_replace('/^```json\s*/i', '', $content);
            $content = preg_replace('/^```\s*/i', '', $content);
            $content = preg_replace('/\s*```$/i', '', $content);
            $content = trim($content);

            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error', [
                    'content' => $content,
                    'error'   => json_last_error_msg(),
                ]);
                return null;
            }

            if (!is_array($decoded)) {
                Log::error('OpenRouter response is not an array', ['decoded' => $decoded]);
                return null;
            }

            return $decoded;

        } catch (\Exception $e) {
            Log::error('OpenRouter exception', ['message' => $e->getMessage()]);
            return null;
        }

    }
}
