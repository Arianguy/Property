<?php

namespace App\Providers;

use App\Models\Contract;
use App\Observers\ContractObserver;
use App\Observers\PermissionObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the PermissionObserver
        Permission::observe(PermissionObserver::class);
        Contract::observe(ContractObserver::class);
    }
}
