<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('personas/index', 'App\Http\ViewComposers\IndexComposer');
        View::composer('personas/create', 'App\Http\ViewComposers\CreateComposer');
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
