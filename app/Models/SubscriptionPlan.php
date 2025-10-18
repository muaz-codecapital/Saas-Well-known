<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name', 'slug', 'plan_type', 'icon', 'badge_text', 'badge_color', 'subtitle',
        'paypal_plan_id', 'stripe_plan_id', 'price_monthly', 'price_yearly',
        'price_two_years', 'price_three_years', 'description',
        'feature_categories', 'modules', 'maximum_allowed_users', 'has_modules',
        'free', 'active', 'featured', 'per_user_pricing', 'users_limit',
        'max_file_upload_size', 'file_space_limit', 'cta_text', 'cta_type',
        'cta_url', 'is_equity_based', 'special_conditions', 'requires_application',
        'sort_order', 'color_scheme'
    ];

    protected $casts = [
        'feature_categories' => 'array',
        'modules' => 'array',
        'is_equity_based' => 'boolean',
        'requires_application' => 'boolean',
        'free' => 'boolean',
        'active' => 'boolean',
        'featured' => 'boolean',
        'per_user_pricing' => 'boolean',
        'has_modules' => 'boolean',
        'maximum_allowed_users' => 'integer',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'price_two_years' => 'decimal:2',
        'price_three_years' => 'decimal:2',
    ];

    // Relationship to features
    public function features()
    {
        return $this->hasMany(SubscriptionPlanFeature::class, 'subscription_plan_id', 'id');
    }

    // Custom method to get features (fallback)
    public function getFeaturesAttribute()
    {
        // Always load features from database to ensure fresh data
        return SubscriptionPlanFeature::where('subscription_plan_id', $this->id)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    public static function availableModules()
    {
        return [
            'projects' => __('Product Planning'),
            'to_dos' => __('Tasks'),
            'brainstorm' => __('Ideation Canvas'),
            'investors' => __('Investors'),
            'business_model' => __('Business Model'),
            'startup_canvas' => __('Startup Canvas'),
            'swot' => __('SWOT Analysis'),
            'pest' => __('PEST Analysis'),
            'pestle' => __('PESTLE Analysis'),
            'business_plan' => __('Business Plan'),
            'marketing_plan' => __('Marketing Plan'),
            'calendar' => __('Calendar'),
            'notes' => __('Note Book'),
            'documents' => __('Documents'),
            'mckinsey' => __('McKinsey 7-S Model'),
            'porter' => __('Porter\'s Five Forces Model'),
        ];
    }

    public static function availablePlanTypes()
    {
        return [
            'standard' => __('Standard'),
            'premium' => __('Premium'),
            'enterprise' => __('Enterprise'),
            'incubation' => __('Incubation Track'),
        ];
    }

    public static function availableColorSchemes()
    {
        return [
            'purple' => __('Purple'),
            'blue' => __('Blue'),
            'green' => __('Green'),
            'orange' => __('Orange'),
            'red' => __('Red'),
        ];
    }

    public static function availableCtaTypes()
    {
        return [
            'button' => __('Button'),
            'link' => __('Link'),
            'application' => __('Application Required'),
            'contact' => __('Contact Us'),
        ];
    }

    public static function availableIcons()
    {
        return [
            'feather-credit-card' => __('Credit Card'),
            'feather-briefcase' => __('Briefcase'),
            'feather-rocket' => __('Rocket'),
            'feather-star' => __('Star'),
            'feather-zap' => __('Lightning'),
            'feather-users' => __('Users'),
            'feather-shield' => __('Shield'),
            'feather-trending-up' => __('Trending Up'),
        ];
    }

    // Scope for active plans
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Scope for featured plans
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope for ordering plans
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }
}
