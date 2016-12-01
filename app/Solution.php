<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'comment', 'verified', 'question_id', 'user_id',
    ];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function mainquestion() {
        return $this->belongsTo('App\Mainquestion', 'question_id');
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
