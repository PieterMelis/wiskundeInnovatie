<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubchaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subchapters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nr');
            $table->string('name');
            $table->integer('chapter_id')->unsigned()->index();
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
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
        Schema::dropIfExists('subchapters');
    }
}
