<?php

namespace App\Providers;

use App\Models\Order;
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

        Gate::define('SuperUser', function(User $user){

            return $user->hasRole(['SuperUser']);
        });
        Gate::define('Security Officer', function(User $user){
            return $user->hasRole(['Security Officer']);
        });
        Gate::define('OPS', function(User $user){
            return $user->hasRole(['OPS']);
        });
        Gate::define('Manager', function(User $user){
            return $user->hasRole(['Manager']);
        });
        Gate::define('Agent', function(User $user){
            return $user->hasRole(['Agent']);
        });
        Gate::define('Driver', function(User $user){
            return $user->hasRole(['Driver']);
        });
        Gate::define('View-Only', function(User $user){
            return $user->hasRole(['View-Only']);
        });
        Gate::define('update-post', function (User $user, Order $order) {
            return $user->id === $order->user_id;
        });
        Gate::define('settings', function ($user)
        {
            return true;
        });
    }
}
