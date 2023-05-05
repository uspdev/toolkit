<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
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
        Permission::firstOrCreate(['name' => 'grad']);
        Permission::firstOrCreate(['name' => 'posgrad']);
        Permission::firstOrCreate(['name' => 'academica']);
        Permission::firstOrCreate(['name' => 'financeira']);
        Permission::firstOrCreate(['name' => 'administrativa']);

        $role = Role::firstOrCreate(['name' => 'diretoria']);
        $role->givePermissionTo(['academica','financeira','administrativa']);
    }
}
