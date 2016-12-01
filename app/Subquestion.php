<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subquestion extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nr', 'question', 'mainquestion_id',
    ];
    
    public functions question() {
        return $this->belongsTo('App\Mainquestion');
    }
    
    public function solution() {
        return $this->hasOne('App\Solution');
    }
    
     public function images() {
        return $this->hasMany('App\Image');
    }
}
