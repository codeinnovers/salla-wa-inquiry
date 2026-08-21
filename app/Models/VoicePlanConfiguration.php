<?php

namespace App\Models;

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
        'days',
        'price',
        'currency',
        'description',
        'is_active',
    ];

    protected $casts = [
        'monthly_search_limit' => 'integer',
        'days' => 'integer',
        'price' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Get search limit by plan slug, fallback to 100.
     */
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

    /**
     * Get plan duration in days by plan slug.
     */
    public static function getDaysForSlug(string $slug): int
    {
        $plan = static::where('slug', strtolower($slug))->where('is_active', true)->first();
        if ($plan && isset($plan->days)) {
            return (int) $plan->days;
        }

        return match (strtolower($slug)) {
            'free' => 3,
            'basic' => 30,
            'pro' => 360,
            default => 30,
        };
    }
}
