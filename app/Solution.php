<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'comment', 'question_id', 'user_id',
    ];
    
    public functions user() {
        return $this->belongsTo('App\User');
    }
    
    public function question() {
        return $this->belongsTo('App\Question');
    }
    
    public function subquestion() {
        return $this->belongsTo('App\Subquestion');
    }
    
    public function solution_steps() {
        return $this->hasMany('App\SolutionStep');
    }
    
     public function images() {
        return $this->hasMany('App\Image');
    }
}
