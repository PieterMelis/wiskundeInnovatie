<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOnImages extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'images', function ( Blueprint $table ) {
			$table->foreign( 'solution_id' )
			      ->references( 'id' )
			      ->on( 'solutions' )
			      ->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'images', function ( Blueprint $table ) {
			$table->dropForeign( [ 'solution_id' ] );
		} );
	}
}
