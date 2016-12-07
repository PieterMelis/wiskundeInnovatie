<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mainquestion;
use App\Chapter;
use App\Subchapter;
use App\User;

class MainquestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function view_add_question(){
        
        $chapters = Chapter::with('subchapters')->get();
        
        return view('admin/add_question', ['chapters' => $chapters]);
    }
}
