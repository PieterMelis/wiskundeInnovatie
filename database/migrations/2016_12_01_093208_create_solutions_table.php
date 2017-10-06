<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->boolean('verified')->default(false);
            $table->integer('verified_by')->unsigned()->nullable();
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('verified_on')->nullable();
            $table->integer('mainquestion_id')->unsigned()->nullable();
            $table->foreign('mainquestion_id')->references('id')->on('mainquestions')->onDelete('cascade');
            $table->integer('subquestion_id')->unsigned()->nullable();
            $table->foreign('subquestion_id')->references('id')->on('subquestions')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('solutions');
    }
}
