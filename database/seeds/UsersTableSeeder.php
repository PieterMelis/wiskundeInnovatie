<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'users' )->insert( [
			'name'       => "Siebe Vanden Eynden",
			'email'      => "siebe.vandeneynden@kdg.be",
			'password'   => bcrypt( 'wachtwoord' ),
			'is_admin'   => 1,
			'verified'   => 1,
			'token_mail' => NULL,
		] );
		DB::table( 'users' )->insert( [
			'name'       => "Siebe Vanden Eynden",
			'email'      => "siebe.vandeneynden@student.kdg.be",
			'password'   => bcrypt( 'wachtwoord' ),
			'verified'   => 1,
			'token_mail' => NULL,
		] );
        DB::table( 'users' )->insert( [
			'name'       => "Sarah Jehin",
			'email'      => "sarah.jehin@student.kdg.be",
			'password'   => bcrypt( 'wiskunde' ),
			'is_admin'   => 1,
			'verified'   => 1,
			'token_mail' => NULL,
		] );
	}
}
