<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chapter;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function show_add_chapter() {
        return view('admin/add_chapter');
    }
    
    
    public function add_chapter(Request $request) {
        
        $this->validate($request, [
            'nr' => 'required|integer|min:1',
            'name' => 'required|string|max:100',
        ]);
        
        $chapter = new Chapter([
            'nr' => $request->nr,
            'name' => $request->name
        ]);
        $chapter->save();
        return redirect('add_chapter');
    }
    
    
    public function show_edit_chapter($id) {
        $chapter = Chapter::find($id);
        return view('admin/edit_chapter', ['chapter' => $chapter]);
    }
    
    public function edit_chapter(Request $request) {
        $chapter = Chapter::find($request->id);
        $chapter->nr = $request->nr;
        $chapter->name = $request->name;
        $chapter->save();
        return redirect('add_chapter');
    }
}
