<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolutionController extends Controller {
	public function __construct() {
		$this->middleware( 'auth' );
	}

	public function getAdd() {
		return view( 'solution.add' );
	}
}
