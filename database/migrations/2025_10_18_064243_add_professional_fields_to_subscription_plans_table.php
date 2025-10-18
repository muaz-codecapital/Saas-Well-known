<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessionalFieldsToSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Professional plan customization fields
            $table->string('plan_type')->default('standard')->after('name'); // standard, premium, enterprise
            $table->string('icon')->nullable()->after('plan_type'); // Icon class or SVG
            $table->string('badge_text')->nullable()->after('icon'); // e.g., "Incubation Track"
            $table->string('badge_color')->default('purple')->after('badge_text'); // Badge color
            $table->text('subtitle')->nullable()->after('badge_text'); // Plan subtitle/description
            $table->json('feature_categories')->nullable()->after('features'); // Organized features by category
            $table->string('cta_text')->default('Get Started')->after('feature_categories'); // Call to action button text
            $table->string('cta_type')->default('button')->after('cta_text'); // button, link, application
            $table->string('cta_url')->nullable()->after('cta_type'); // Custom CTA URL
            $table->boolean('is_equity_based')->default(false)->after('cta_url'); // For equity-based plans
            $table->text('special_conditions')->nullable()->after('is_equity_based'); // Special conditions text
            $table->boolean('requires_application')->default(false)->after('special_conditions'); // Requires application
            $table->integer('sort_order')->default(0)->after('requires_application'); // For ordering plans
            $table->string('color_scheme')->default('purple')->after('sort_order'); // Plan color scheme
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'plan_type',
                'icon',
                'badge_text',
                'badge_color',
                'subtitle',
                'feature_categories',
                'cta_text',
                'cta_type',
                'cta_url',
                'is_equity_based',
                'special_conditions',
                'requires_application',
                'sort_order',
                'color_scheme'
            ]);
        });
    }
}
