<?php

namespace App\Providers;

use App\Helpers\DataHelpers;
use App\Models\SiteManagement;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        view()->composer('*', function ($view) {
            $sitelogo = asset('assets/images/new-logo-white.png');
            $getusersess = Session::get('userlogin');
            if (isset($getusersess)) {
                $siteuser = User::where('id', auth()->id())->first();
            } else {
                $siteuser = [];
                $getsite = [];
            }
            $view->with(['sitelogo' => $sitelogo, 'getusersess' => $getusersess]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
