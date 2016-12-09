<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subquestion extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nr', 'question', 'has_subquestions', 'mainquestion_id',
    ];
    
    public function question() {
        return $this->belongsTo('App\Mainquestion');
    }
    
    public function solution() {
        return $this->hasMany('App\Solution');
    }
    
     public function images() {
        return $this->hasMany('App\Image');
    }
}
