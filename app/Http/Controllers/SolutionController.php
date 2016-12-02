<?php

namespace App\Http\Controllers;

use App\Solution;
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
    
    public function accept_solution($id) {
        $solution = Solution::find($id);
        $solution->verified = 1;
        $solution->verified_by = Auth::user()->id;
        $solution->verified_on = \Carbon\Carbon::now();
        $solution->save();
    }
    
    public function decline_solution($id) {
        $solution = Solution::find($id);
        $solution->verified = 2; //2 means a solution is declined and will not appear in the new solutions overview
        $solution->save();
    }
    
    
}
