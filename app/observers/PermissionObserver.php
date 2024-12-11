<?php

namespace App\Observers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return void
     */
    public function created(Permission $permission)
    {
        // Retrieve or create the Super Admin role
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // Assign the newly created permission to Super Admin
        $superAdminRole->givePermissionTo($permission);
    }
}
