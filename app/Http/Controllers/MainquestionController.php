<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mainquestion;
use App\User;

class MainquestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function view_add_question(){
        
        $questions = Mainquestion::all();
        
        return view('admin/add_question', ['questions' => $questions]);
    }
}
