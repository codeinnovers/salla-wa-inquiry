<?php

namespace Mega\SallaVoiceAI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VoicePlanConfiguration extends Model
{
    use HasFactory;

    protected $table = 'voice_plan_configurations';

    protected $fillable = [
        'name',
        'slug',
        'monthly_search_limit',
        'price',
        'currency',
        'description',
        'is_active',
    ];

    protected $casts = [
        'monthly_search_limit' => 'integer',
        'price' => 'float',
        'is_active' => 'boolean',
    ];

    public static function getLimitForSlug(string $slug): int
    {
        $plan = static::where('slug', strtolower($slug))->where('is_active', true)->first();
        if ($plan) {
            return (int) $plan->monthly_search_limit;
        }

        return match (strtolower($slug)) {
            'basic' => 2000,
            'pro' => 10000,
            default => 100,
        };
    }
}
