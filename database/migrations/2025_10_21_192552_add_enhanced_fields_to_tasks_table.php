<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnhancedFieldsToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('priority')->default('medium')->after('status');
            $table->string('group')->nullable()->after('start_date');
            $table->string('workspace_type')->nullable()->after('group');
            $table->integer('estimated_hours')->nullable()->after('due_date');
            $table->integer('actual_hours')->nullable()->after('estimated_hours');
            $table->integer('progress')->default(0)->after('actual_hours');
            $table->json('tags')->nullable()->after('progress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'priority',
                'group',
                'workspace_type',
                'estimated_hours',
                'actual_hours',
                'progress',
                'tags'
            ]);
        });
    }
}
