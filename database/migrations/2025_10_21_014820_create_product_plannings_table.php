<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_plannings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('workspace_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['idea', 'validation', 'in_development', 'testing', 'released', 'archived'])->default('idea');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('group_type')->nullable(); // 'milestone', 'feature', 'epic'
            $table->unsignedBigInteger('group_id')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->integer('progress')->default(0); // 0-100
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->default(0);
            $table->json('tags')->nullable();
            $table->json('attachments')->nullable();
            $table->json('dependencies')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['workspace_id', 'status']);
            $table->index(['workspace_id', 'product_id']);
            $table->index(['workspace_id', 'department_id']);
            $table->index(['group_type', 'group_id']);
            $table->index(['assigned_to']);
            $table->index(['due_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_plannings');
    }
}
