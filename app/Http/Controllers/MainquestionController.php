<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mainquestion;
use App\Subquestion;
use App\Chapter;
use App\Subchapter;
use App\User;

class MainquestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function view_question_overview() {
        //
        $chapters = Chapter::with('subchapters.mainquestions.subquestions')->get();
        //dd($chapters);
        return view('admin/question_overview', ['chapters' => $chapters]);
    }
    
    public function view_add_question(){
        
        $chapters = Chapter::with('subchapters')->get();
        
        return view('admin/add_question', ['chapters' => $chapters]);
    }
    
    public function add_question(Request $request){
        
        //dump($request);
        //dd($request->questions_latex[0]);
        
        $mainquestion = new Mainquestion([
            'nr' => $request->nr,
            'question' => $request->questions_latex[0],
            'subchapter_id' => $request->chapter,
            'has_subquestions' => 1
        ]);
        $mainquestion->save();
        
        foreach($request->subq as $subq) {
            $nr = explode("*", $subq)[0];
            $question = explode("*", $subq)[1];
            
            $subquestion = new Subquestion([
                'nr' => $nr,
                'question' => $question,
                'has_subquestions' => 1,
                'mainquestion_id' => $mainquestion->id
            ]);
            $subquestion->save();
            
        }
        
        return redirect('add_question');
        
    }
}
