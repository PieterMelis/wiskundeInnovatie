<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignOnMainQuestions extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'mainquestions', function ( Blueprint $table ) {
			$table->dropForeign( [ 'chapter_id' ] );
			$table->dropColumn( 'chapter_id' );
			$table->integer( 'subchapter_id' )->unsigned()->after( 'has_subquestions' );
			$table->foreign( 'subchapter_id' )
			      ->references( 'id' )
			      ->on( 'subchapters' )
			      ->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'mainquestions', function ( Blueprint $table ) {
			$table->dropForeign( [ 'subchapter_id' ] );
			$table->dropColumn( 'subchapter_id' );
			$table->integer( 'chapter_id' )->unsigned()->index()->after( 'has_subquestions' );
			$table->foreign( 'chapter_id' )
			      ->references( 'id' )
			      ->on( 'chapters' )
			      ->onDelete( 'cascade' );
		} );
	}
}
