<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // app/Http/Controllers/PermissionController.php

    public function index()
    {
        $permissions = Permission::all();

        // Group permissions by main module (users, roles, etc.)
        $groupedPermissions = collect();

        foreach ($permissions as $permission) {
            // Extract module name (users, roles, etc.) from permission name
            $module = explode(' ', str_replace('_', ' ', $permission->name))[0];
            // Remove 's' from the end if it exists (users -> user)
            $module = rtrim($module, 's');

            if (!$groupedPermissions->has($module)) {
                $groupedPermissions[$module] = collect();
            }
            $groupedPermissions[$module]->push($permission);
        }

        $moduleColors = [
            'user' => 'from-blue-500 to-blue-600',
            'role' => 'from-green-500 to-green-600',
            'permission' => 'from-purple-500 to-purple-600',
            'property' => 'from-yellow-500 to-yellow-600',
            'contract' => 'from-indigo-500 to-indigo-600',
            'tenant' => 'from-pink-500 to-pink-600'
        ];

        return view('admin.permissions.index', compact('groupedPermissions', 'moduleColors'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name']
        ]);

        Permission::create($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission)]
        ]);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }
    public function destroy(Permission $permission)
    {
        try {
            // Add logging to debug
            \Log::info('Attempting to delete permission: ' . $permission->id);

            // Check if permission is in use
            if ($permission->roles()->count() > 0) {
                Log::warning('Cannot delete permission - has roles assigned');
                return back()->with('error', 'Cannot delete permission that is assigned to roles');
            }

            $name = $permission->name;
            $permission->delete();

            \Log::info('Permission deleted successfully: ' . $name);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting permission: ' . $e->getMessage());
            return back()->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }
}
