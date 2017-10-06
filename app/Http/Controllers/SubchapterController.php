<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Chapter;
use App\Subchapter;

class SubchapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function show_add_subchapter() {
        
        $chapters = Chapter::all();
        
        return view('admin/add_subchapter', ['chapters' => $chapters]);
    }
    
    public function add_subchapter(Request $request) {
        
        $this->validate($request, [
            'nr' => 'required|integer|min:1',
            'name' => 'required|string|max:100',
            'chapter' => 'required',
        ]);
        
        $subchapter = new Subchapter([
            'nr' => $request->nr,
            'name' => $request->name,
            'chapter_id' => $request->chapter
        ]);
        $subchapter->save();
        return redirect('add_subchapter');
    }
}
