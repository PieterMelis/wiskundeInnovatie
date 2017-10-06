<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('email_domain', function($attribute, $value, $parameters, $validator){
        	$email = explode("@", $value);
        	return in_array($email[1], $parameters);
        });

        Validator::replacer('email_domain', function($message, $attribute, $rule, $parameters){
	        return str_replace(':parameters', implode(", ", $parameters), $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
