<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainquestion extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nr', 'question', 'has_subquestions', 'chapter_id',
    ];
    
    
    public function chapter() {
        return $this->belongsTo('App\Chapter');
    }
    
    public function subchapter()
    {
        return $this->belongsTo('App\Subchapter');
    }
    
    public function subquestions()
    {
        return $this->hasMany('App\Subquestion');
    }
    
    public function solution() {
        return $this->hasMany('App\Solution');
    }
    
     public function images() {
        return $this->hasMany('App\Image');
    }
}
