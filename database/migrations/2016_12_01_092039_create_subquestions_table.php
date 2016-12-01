<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subquestions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nr');
            $table->string('question');
            $table->boolean('has_subquestions');
            $table->integer('mainquestion_id')->unsigned()->index();
            $table->foreign('mainquestion_id')->references('id')->on('mainquestions')->onDelete('cascade');
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
        Schema::dropIfExists('subquestions');
    }
}
