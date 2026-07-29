<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('teste', function ($user) {
            return $user->level == 'admin' ? true : false;
        });

        Gate::define('teste2', function ($user) {
            return $user;
        });

        Gate::define('manageApiKeys', function (User $user, User $owner): bool {
            return $user->is($owner) || $user->level === 'admin';
        });
    }
}
