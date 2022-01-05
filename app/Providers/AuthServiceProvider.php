<?php

namespace App\Providers;

use App\Models\AddressesList;
use App\Models\Order;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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

        Gate::define('SuperUser', function (User $user) {

            return $user->hasRole(['SuperUser']);
        });
        Gate::define('Security Officer', function (User $user) {
            return $user->hasRole(['Security Officer']);
        });
        Gate::define('OPS', function (User $user) {
            return $user->hasRole(['OPS']);
        });
        Gate::define('Manager', function (User $user) {
            return $user->hasRole(['Manager']);
        });
        Gate::define('Agent', function (User $user) {
            return $user->hasRole(['Agent']);
        });
        Gate::define('Driver', function (User $user) {
            return $user->hasRole(['Driver']);
        });
        Gate::define('View-Only', function (User $user) {
            return $user->hasRole(['View-Only']);
        });
        Gate::define('Client', function (User $user) {
            return $user->hasRole(['Client']);
        });
        Gate::define('Administration', function (User $user) {
            return $user->hasRoles(['SuperUser', 'OPS', 'Manager']);
        });
        Gate::define('manage-agent', function (User $user, Order $order) {
            foreach ($order->tracker as $item) {
                if ($user->company->first()->id ?? 'not found'  == $item->company_id) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('manage-user-order', function (User $user, Order $order) {
            return $user->id == $order->agent_id;
        });
        Gate::define('manage-client-exel', function (User $user, Order $order) {
            return (int)$user->id === (int)$order->client_id;
        });
        Gate::define('manage-client-address', function (User $user, AddressesList $addressesList) {
            return (int)$user->id === (int)$addressesList->user_id;
        });
        Gate::define('manage-client-report', function (User $user, Report $report) {
            return (int)$user->id === (int)$report->user_id;
        });
        Gate::define('manage-driver', function (User $user, Order $order) {
            foreach ($order->tracker as $item) {
                if ($user->id == $item->driver_id) {
                    return true;
                }
            }
            return false;
        });
        Gate::define(   'manage-client', function (User $user, Order $order) {
            // dd($order);
            // if ($user->id == $order->client_id){
            //	dd($user->payer()->get()->pluck('id')->contains($order->payer_id));
            if ($user->payer()->get()->pluck('id')->contains($order->payer_id)) {
                return true;
            }
            //}
            return false;

        });
        Gate::define('settings', function ($user) {
            return true;
        });
    }
}
