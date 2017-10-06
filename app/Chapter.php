<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nr', 'name',
    ];
    
    
    public function mainquestions()
    {
        return $this->hasMany('App\Mainquestion');
    }
    
    public function subchapters()
    {
        return $this->hasMany('App\Subchapter');
    }
    
    
}
