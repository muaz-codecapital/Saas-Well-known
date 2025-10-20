<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('workspace_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#667eea'); // Hex color code
            $table->text('description')->nullable();
            $table->unsignedInteger('usage_count')->default(0);
            $table->timestamps();

            $table->index(['workspace_id', 'name']);
            $table->unique(['workspace_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}