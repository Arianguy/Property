<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions grouped by module
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',  // Overall user management

            // Role Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'manage roles',  // Overall role management

            // Permission Management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'manage permissions',  // Overall permission management

            // Property Management
            'view property',
            'create property',
            'edit property',
            'delete property',
            'manage property',  // Overall property management

            // Contract Management
            'view contract',
            'create contract',
            'edit contract',
            'delete contract',
            'manage contracts',  // Overall contract management

            // Tenant Management
            'view tenants',
            'create tenants',
            'edit tenants',
            'delete tenants',
            'manage tenants',    // Overall tenant management

            // Add other permissions as needed
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // 1. Super Admin
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // 2. Owner
        $ownerRole = Role::create(['name' => 'Owner']);

        // Assign existing permissions to roles
        $ownerRole->givePermissionTo([
            'view property',
            'view contract',
            'view tenants'
        ]);

        // 3. Accountant
        $accountantRole = Role::create(['name' => 'Accountant']);
        $accountantRole->givePermissionTo([
            'view property',
            'create property',
            'view contract',
            'create contract',
            'view tenants'
        ]);

        // 4. Estate Agent
        $agentRole = Role::create(['name' => 'Estate Agent']);
        $agentRole->givePermissionTo([
            'view property',
            'view contract',
            'create contract',
            'view tenants',
            'create tenants',
            'edit tenants'
        ]);

        // 5. Tenant
        $tenantRole = Role::create(['name' => 'Tenant']);
        // No specific permissions for tenants in the admin system

        // Assign Super Admin role to specific user
        $user = User::find(1); // Change this to your user ID
        if ($user) {
            $user->assignRole('Super Admin');
        }
    }
}
