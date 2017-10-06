<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolutionStep extends Model
{
    protected $table = "solution_steps";
    
    protected $fillable = [
        'answer', 'solution_id','step'
    ];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    
}
