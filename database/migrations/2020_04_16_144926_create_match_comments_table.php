<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('match_id');
            $table->unsignedSmallInteger('comment_number')->default(1);
            $table->unsignedTinyInteger('voted_to')->default(0);
            $table->string('name', 20)->nullable();
            $table->string('comment', 300);
            $table->boolean('open_status')->default(1);
            $table->timestamps();
            $table
                ->foreign('match_id')
                ->references('id')
                ->on('matches')
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
        Schema::dropIfExists('match_comments');
        Schema::dropIfExists('matches');
    }
}
