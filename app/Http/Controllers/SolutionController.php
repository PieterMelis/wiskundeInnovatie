<?php

namespace App\Http\Controllers;

use App\Mainquestion;
use App\Solution;
use App\SolutionStep;
use App\Subquestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller {
	public function __construct() {
		$this->middleware( 'auth' );
	}

	public function getAdd( Mainquestion $mainQuestion, Subquestion $subQuestion = NULL ) {
		$question = [];
		$question[] = $mainQuestion->question;

		if($this->check_if_subQuestion_belongs_to_mainQuestion($mainQuestion, $subQuestion)){
			$question[] = $subQuestion->question;
		}

		return view( 'solution.add', [
			"questions" => $question,
		] );
	}

	public function postAdd( Mainquestion $mainQuestion, Subquestion $subQuestion = NULL, Request $request ) {
		// Todo: Add validation
		$solution_steps = $request->solution_latex;

		if($this->check_if_subQuestion_belongs_to_mainQuestion($mainQuestion, $subQuestion)){
			// Has sub question
			dump('subquestion');
			$solution = $request->user()->solutions()->create([
				"subquestion_id" => $subQuestion->id,
				"mainquestion_id" => $mainQuestion->id,
				"comment" => "",
			]);
		}
		else{
			// Main question
			$solution = $request->user()->solutions()->create([
				"mainquestion_id" => $mainQuestion->id,
				"comment" => "",
			]);
		}

		foreach ($solution_steps as $step)
		{
			dump($step);
			$solution->solution_steps()->create([
				"step" => $step,
			]);
		}
		dd($solution_steps);
	}

	private function check_if_subQuestion_belongs_to_mainQuestion(Mainquestion $mainQuestion, Subquestion $subQuestion){
		return !empty($subQuestion->toArray()) && $subQuestion->questions->id == $mainQuestion->id;
	}

	public function view_new_solutions() {

		//verified not in database yet --> remigrate database
		//$new_solutions = Solution::where('verified', 1)->has('solution_steps')->with('solution_steps')->get();
		$new_solutions = Solution::with( 'mainquestion' )
		                         ->with( 'user' )
		                         ->get();

		return view( 'admin/new_solutions', [ 'new_solutions' => $new_solutions ] );
	}

	public function view_new_solution_details( $id ) {

		$solution = Solution::find($id)->has( 'solution_steps' )
		                    ->with( 'solution_steps' )
		                    ->with( 'mainquestion' )
		                    ->with( 'user' )
		                    ->first();

		return view( 'admin/solution_details', [ 'solution' => $solution ] );

	}

	public function accept_solution( $id ) {
		$solution              = Solution::find( $id );
		$solution->verified    = 1;
		$solution->verified_by = Auth::user()->id;
		$solution->verified_on = Carbon::now();
		$solution->save();
	}

	public function decline_solution( $id ) {
		$solution           = Solution::find( $id );
		$solution->verified = 2; //2 means a solution is declined and will not appear in the new solutions overview
		$solution->save();
	}


}
