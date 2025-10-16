<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('company_name')->nullable();
            $table->string('industry')->nullable();
            $table->string('current_stage')->nullable();
            $table->string('team_size')->nullable();
            $table->string('monthly_revenue')->nullable();
            $table->string('funding_goal')->nullable();
            $table->string('partnership_timeline')->nullable();
            $table->string('subject')->nullable();
            $table->text('about_startup')->nullable();
            $table->string('pitch_deck')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('startup_details');
    }
}
