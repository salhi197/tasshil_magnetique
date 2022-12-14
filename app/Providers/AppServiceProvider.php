<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Config;
use App\Matricule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function boot()
    {
        Schema::defaultStringLength(191);

        $matricules = Matricule::all('matricule');
        Config::set('matricules', $matricules);



        app()->singleton('lang',function (){
            if (auth()->user()) {
                if (empty(auth()->user()->lang)) {
                    return 'en';
                }else{
                    return auth()->user()->lang;
                }
            }else{
                if (session()->has('lang')) {
                    return session()->get('lang');
                }else{
                    return 'en';
                }
            }
        });
    }
}
