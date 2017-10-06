<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'url', 'mainquestion_id', 'subquestion_id', 'solution_id',
    ];
    
    public function mainquestion() {
        $this->belongsTo('App\Mainquestion');
    }
    
    public function subquestion() {
        $this->belongsTo('App\Subquestion');
    }
    
    public function solution() {
        $this->belongsTo('App\Solution');
    }
    
}
