<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view users')->only(['index', 'show']);
        // $this->middleware('permission:create users')->only(['create', 'store']);
        // $this->middleware('permission:edit users')->only(['edit', 'update']);
        // $this->middleware('permission:delete users')->only('destroy');
    }

    public function index()
    {
        $users = User::with('roles')
            ->when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                // Non-super admins can't see super admin users
                return $query->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'Super Admin');
                });
            })
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->getAvailableRoles();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id']
        ]);

        // Validate selected roles
        $this->validateRoleSelection($request->roles);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Get role names instead of IDs
        $roles = Role::whereIn('id', $request->roles)->pluck('name');
        $user->assignRole($roles);

        event(new Registered($user));

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }
    public function show(User $user)
    {
        if (!$this->canManageUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $user->load('roles', 'permissions');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!$this->canManageUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $roles = $this->getAvailableRoles();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }
    public function update(Request $request, User $user)
    {
        if (!$this->canManageUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
            'password' => ['nullable', 'confirmed', Password::defaults()]
        ]);

        // Validate selected roles
        $this->validateRoleSelection($request->roles);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Get role names instead of IDs
        $roles = Role::whereIn('id', $request->roles)->pluck('name');
        $user->syncRoles($roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }
    public function destroy(User $user)
    {
        if (!$this->canManageUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        if ($user->hasRole('Super Admin') && User::role('Super Admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the last Super Admin user');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function profile()
    {
        $user = auth()->user()->load('roles', 'permissions');
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()]
        ]);

        if (isset($validated['current_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * Get roles that the authenticated user can assign.
     */
    private function getAvailableRoles()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            return Role::all();
        }

        // Non-super admins can't assign the Super Admin role
        return Role::where('name', '!=', 'Super Admin')->get();
    }

    /**
     * Validate if the authenticated user can assign the selected roles.
     */
    private function validateRoleSelection($roles)
    {
        if (
            !auth()->user()->hasRole('Super Admin') &&
            in_array(Role::where('name', 'Super Admin')->first()->id, $roles)
        ) {
            abort(403, 'You cannot assign Super Admin role.');
        }
    }

    /**
     * Check if the authenticated user can manage the target user.
     */
    private function canManageUser(User $targetUser): bool
    {
        // Super Admin can manage everyone
        if (auth()->user()->hasRole('Super Admin')) {
            return true;
        }

        // Non-super admins can't manage super admins
        if ($targetUser->hasRole('Super Admin')) {
            return false;
        }

        // Check if user has permission to manage users
        return auth()->user()->hasPermissionTo('manage users');
    }
}
