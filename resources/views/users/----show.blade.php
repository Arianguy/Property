<!-- resources/views/users/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <a href="{{ route('users.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Information -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-3">
                                User Information
                            </h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $user->created_at->format('F j, Y h:i A') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $user->updated_at->format('F j, Y h:i A') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Roles and Permissions -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-3">
                                Roles & Permissions
                            </h3>

                            <!-- Roles -->
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500">Assigned Roles</h4>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @forelse($user->roles as $role)
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-500">No roles assigned</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-500">Permissions</h4>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @forelse($user->getAllPermissions() as $permission)
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-500">No direct permissions assigned</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('users.edit', $user) }}"
                           class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Edit User
                        </a>

                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete User
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Activity Log (if you have it implemented) -->
                    @if(isset($user->activities) && count($user->activities) > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-3">Recent Activity</h3>
                            <div class="mt-4">
                                <ul class="space-y-4">
                                    @foreach($user->activities as $activity)
                                        <li class="text-sm text-gray-600">
                                            {{ $activity->description }} -
                                            {{ $activity->created_at->diffForHumans() }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
