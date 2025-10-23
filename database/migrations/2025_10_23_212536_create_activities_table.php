<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('workspace_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->enum('type', ['call', 'email', 'meeting', 'note', 'task', 'demo', 'proposal', 'contract', 'other']);
            $table->string('subject');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['completed', 'scheduled', 'cancelled', 'no_show'])->default('completed');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration_minutes')->nullable(); // For calls, meetings
            $table->string('location')->nullable(); // For meetings
            $table->json('attachments')->nullable();
            $table->json('metadata')->nullable(); // Additional data like call recording URL, email thread ID, etc.
            $table->timestamps();

            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['workspace_id', 'contact_id']);
            $table->index(['workspace_id', 'company_id']);
            $table->index(['workspace_id', 'created_by']);
            $table->index(['contact_id', 'type']);
            $table->index(['scheduled_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
