<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question', 100);
            $table->string('choice1', 50);
            $table->string('choice2', 50);
            $table->string('choice3', 50);
            $table->string('choice4', 50);
            $table->string('choice5', 50);
            $table->dateTime('close_at');
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
        Schema::dropIfExists('surveys');
    }
}
