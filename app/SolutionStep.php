<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolutionStep extends Model
{
    protected $table = "solution_steps";
    
    protected $fillable = [
        'answer', 'solution_id',
    ];
    
    public functions user() {
        return $this->belongsTo('App\User');
    }
    
    
}
