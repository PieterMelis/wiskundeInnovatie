<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subchapter extends Model
{
    //
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nr', 'name', 'chapter_id',
    ];
    
    
    public function chapter() {
        return $this->belongsTo('App\Chapter');
    }
    
    public function mainquestions()
    {
        return $this->hasMany('App\Mainquestion');
    }
}
