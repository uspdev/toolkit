<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

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
        // criando algumas permissões a serem utilizadas pela aplicação
        // e que podem ser atribuídas aos usuários
        Permission::firstOrCreate(['guard_name' => 'app', 'name' => 'grad']);
        Permission::firstOrCreate(['guard_name' => 'app', 'name' => 'posgrad']);
        Permission::firstOrCreate(['guard_name' => 'app', 'name' => 'lattes']);
    }
}
