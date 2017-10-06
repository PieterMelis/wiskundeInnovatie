<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
	use SoftDeletes;

	/**
	 * Function that is standard execute on events
	 */
	public static function boot()
	{
		parent::boot();

		//Executed when a new user is made
		static::creating(function ($user)
		{
			// Set the token for an email
			$user->token_mail = str_random(30);
		});
	}

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [ 'deleted_at' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'is_admin', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * Handle database when the email is confirmed
	 */
	public function confirmEmail()
	{
		$this->verified = true;
		$this->token_mail = NULL;

		$this->save();
	}
    
    public function solutions() {
        return $this->hasMany('App\Solution');
    }
}
