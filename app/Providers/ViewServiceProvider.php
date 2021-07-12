<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

// https://laravel.com/docs/8.x/views#view-composers

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        //View::composer('profile', ProfileComposer::class);

        // Using closure based composers...
        View::composer('*', function ($view) {

            $sub = [];
            foreach (config('laravel-usp-theme.available-skins') as $sk) {
                $env = config('laravel-usp-theme.skin') == $sk ? ' (.env)' : '';
                $sub[] = [
                    'text' => $sk . $env,
                    'url' => 'theme-skin-change?skin=' . $sk,
                ];
            }

            \UspTheme::addMenu('theme', [
                'text' => '<span class="badge badge-warning">skin</span> ' . \UspTheme::getSkin(),
                'submenu' => $sub,
                'align' => 'right',
                'can' => 'user'
            ]);
        });

    }
}
