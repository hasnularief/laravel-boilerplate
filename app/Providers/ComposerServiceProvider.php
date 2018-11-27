<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Views\Composers\SidebarMenuComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.sidebar', SidebarMenuComposer::class);
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
