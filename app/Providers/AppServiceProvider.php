<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Observers\PageObserver;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($_SERVER['HTTP_USER_AGENT']);        

        // Page::observe(PageObserver::class);
        // $cmsPages = Cache::remember('cmsPages', 60 * 60, function () {
        //     return Page::where(['status' => 1])->get(['title', 'slug', 'group_id']);
        // });

        // $browserCheck = '';
        // if (isset($_SERVER) && isset($_SERVER["HTTP_USER_AGENT"])) {
        //     $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        //     if (stripos($ua, "iPhone") !== false || stripos($ua, "iPad") !== false) {
        //         $browserCheck = 'iphone';
        //     }
        // }
        // View::share('cmsPages', $cmsPages);
        // View::share('detectDevice', $browserCheck);
    }
}
