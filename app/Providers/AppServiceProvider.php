<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Task;
use App\Policies\TaskPolicy;

class AuthServiceProvider extends ServiceProvider
{
    // /**
    //  * Register any application services.
    //  */
    // public function register(): void
    // {
       
    // }

    // /**
    //  * Bootstrap any application services.
    //  */
    // public function boot(): void
    // {
    //     //
    // }
    /**
     * 
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
