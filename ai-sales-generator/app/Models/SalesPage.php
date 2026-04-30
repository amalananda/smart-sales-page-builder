<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'features',
        'target_audience',
        'price',
        'usp',
        'tone',
        'template',
        'headline',
        'subheadline',
        'product_description',
        'benefits',
        'features_breakdown',
        'testimonials',
        'cta_text',
        'cta_button',
        'pricing_label',
        'raw_generated',
    ];
    protected $casts = [
        'benefits' => 'array',
        'features_breakdown' => 'array',
        'testimonials' => 'array',
        'raw_generated' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
