<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subchapter extends Model
{
    //
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'nr', 'name', 'mainchapter_id',
    ];
    
    
    public functions chapter() {
        return $this->belongsTo('App\Chapter');
    }
    
    public function mainquestions()
    {
        return $this->hasMany('App\Mainquestion');
    }
}
