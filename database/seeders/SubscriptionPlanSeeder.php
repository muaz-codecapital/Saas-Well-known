<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing plans and features (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\SubscriptionPlanFeature::truncate();
        SubscriptionPlan::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Standard Plan (with pricing)
        $standardPlan = SubscriptionPlan::create([
            'name' => 'Standard Plan',
            'plan_type' => 'standard',
            'icon' => 'feather-rocket',
            'badge_text' => 'Most Popular',
            'badge_color' => 'blue',
            'subtitle' => 'Perfect for individual entrepreneurs and small teams',
            'price_monthly' => 24.99,
            'price_yearly' => 259.99,
            'maximum_allowed_users' => 10,
            'max_file_upload_size' => 10240,
            'file_space_limit' => 1000,
            'cta_text' => 'Get Started',
            'cta_type' => 'button',
            'is_equity_based' => false,
            'requires_application' => false,
            'sort_order' => 1,
            'color_scheme' => 'blue',
            'active' => true,
            'featured' => true,
        ]);

        // Standard Plan Features
        $standardFeatures = [
            ['icon' => 'feather-brain', 'heading' => 'Advanced Planning', 'description' => 'Business Model Canvas, Financial Forecasts, SWOT, Roadmap, McKinsey 7S'],
            ['icon' => 'feather-bar-chart-2', 'heading' => 'Execution Tools', 'description' => 'Kanban board with advanced options, project & task management, CRM for leads/customers'],
            ['icon' => 'feather-users', 'heading' => 'Collaboration', 'description' => 'Workspace for up to 10 users, Google Calendar integration'],
            ['icon' => 'feather-file-text', 'heading' => 'Smart Reporting', 'description' => 'Customizable sections, PDF generator for business plans'],
            ['icon' => 'feather-unlock', 'heading' => 'Flexibility', 'description' => 'Cancel anytime']
        ];

        foreach ($standardFeatures as $index => $feature) {
            $standardPlan->features()->create([
                'icon' => $feature['icon'],
                'heading' => $feature['heading'],
                'description' => $feature['description'],
                'sort_order' => $index
            ]);
        }

        // Enterprise Plan (Contact Us)
        $enterprisePlan = SubscriptionPlan::create([
            'name' => 'Enterprise Plan',
            'plan_type' => 'enterprise',
            'icon' => 'feather-users',
            'badge_text' => 'Custom Solution',
            'badge_color' => 'purple',
            'subtitle' => 'Tailored solutions for large organizations and enterprises',
            'price_monthly' => 0,
            'price_yearly' => 0,
            'maximum_allowed_users' => 999,
            'max_file_upload_size' => 102400,
            'file_space_limit' => 10000,
            'cta_text' => 'Contact Us',
            'cta_type' => 'contact',
            'cta_url' => '/contact',
            'is_equity_based' => false,
            'special_conditions' => 'Custom pricing based on your needs',
            'requires_application' => false,
            'sort_order' => 2,
            'color_scheme' => 'purple',
            'active' => true,
            'featured' => false,
        ]);

        // Enterprise Plan Features
        $enterpriseFeatures = [
            ['icon' => 'feather-check-circle', 'heading' => 'All Standard Features', 'description' => 'Everything included in the Standard Plan'],
            ['icon' => 'feather-shield', 'heading' => 'Advanced Security', 'description' => 'Enterprise-grade security and compliance features'],
            ['icon' => 'feather-headphones', 'heading' => 'Priority Support', 'description' => '24/7 dedicated support with SLA guarantees'],
            ['icon' => 'feather-settings', 'heading' => 'Custom Integration', 'description' => 'API access and custom integrations with your existing tools'],
            ['icon' => 'feather-users', 'heading' => 'Unlimited Users', 'description' => 'No user limits, scale as you grow'],
            ['icon' => 'feather-award', 'heading' => 'Training & Onboarding', 'description' => 'Comprehensive training and onboarding for your team']
        ];

        foreach ($enterpriseFeatures as $index => $feature) {
            $enterprisePlan->features()->create([
                'icon' => $feature['icon'],
                'heading' => $feature['heading'],
                'description' => $feature['description'],
                'sort_order' => $index
            ]);
        }
    }
}