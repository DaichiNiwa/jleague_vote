<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_id');
            $table->unsignedSmallInteger('comment_number')->default(1);
            $table->unsignedTinyInteger('voted_to');
            $table->string('name', 20)->nullable();
            $table->string('comment', 300);
            $table->boolean('open_status')->default(1);
            $table->timestamps();
            $table
                ->foreign('survey_id')
                ->references('id')
                ->on('surveys')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_comments');
        Schema::dropIfExists('surveys');
    }
}
