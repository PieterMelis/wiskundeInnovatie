<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('mainquestion_id')->unsigned()->nullable();
            $table->foreign('mainquestion_id')->references('id')->on('mainquestions')->onDelete('cascade');
            $table->integer('subquestion_id')->unsigned()->nullable();
            $table->foreign('subquestion_id')->references('id')->on('subquestions')->onDelete('cascade');
            $table->integer('solution_id')->unsigned()->nullable();
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('images');
    }
}
