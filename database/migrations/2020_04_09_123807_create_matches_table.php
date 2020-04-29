<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('team1_id');
            $table->unsignedSmallInteger('team2_id');
            $table->unsignedSmallInteger('team1_votes')->default(0);
            $table->unsignedSmallInteger('team2_votes')->default(0);
            $table->unsignedTinyInteger('tournament')->default(0);
            $table->unsignedTinyInteger('tournament_sub')->nullable();
            $table->unsignedTinyInteger('homeaway')->default(0);
            $table->dateTime('start_at');
            $table->dateTime('open_at');
            $table->unsignedTinyInteger('focus_status')->default(0);
            $table->unsignedTinyInteger('twitter_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
