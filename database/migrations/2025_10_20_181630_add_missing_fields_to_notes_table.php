<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->string('reference_file')->nullable()->after('cover_photo');
            $table->string('workspace')->nullable()->after('notes');
            $table->json('tags')->nullable()->after('workspace');
            $table->timestamp('date')->nullable()->after('updated_at');
            $table->text('attachments')->nullable()->after('tags'); // For storing attachment metadata as JSON
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['reference_file', 'workspace', 'tags', 'date', 'attachments']);
        });
    }
}
