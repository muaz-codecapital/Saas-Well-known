<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanFeature extends Model
{
    use HasFactory;

    protected $table = 'subscription_plan_features';

    protected $fillable = [
        'subscription_plan_id',
        'icon',
        'heading',
        'description',
        'sort_order'
    ];

    // Relationship to subscription plan
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    // Scope for ordering features
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }
}
