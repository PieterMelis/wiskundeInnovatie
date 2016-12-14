<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Solution extends Model implements HasMedia
{
	use HasMediaTrait;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'comment', 'verified', 'verified_by', 'verified_on', 'mainquestion_id', 'subquestion_id', 'user_id',
    ];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function mainquestion() {
        return $this->belongsTo('App\Mainquestion');
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
    
    public function verifier() {
        return $this->belongsTo('App\User', 'verified_by');
    }
    
}
