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

	public function view_new_solutions(){

		//verified not in database yet --> remigrate database
		//$new_solutions = Solution::where('verified', 1)->has('solution_steps')->with('solution_steps')->get();
		$new_solutions = Solution::with('mainquestion')
		                         ->with('user')
		                         ->get();

		return view('admin/new_solutions', ['new_solutions' => $new_solutions]);
	}

	public function view_new_solution_details($id) {

		$solution = Solution::has('solution_steps')
		                    ->with('solution_steps')->where('id', $id)
		                    ->with('mainquestion')
		                    ->with('user')
		                    ->first();
		return view('admin/solution_details', ['solution' => $solution]);

	}
}
