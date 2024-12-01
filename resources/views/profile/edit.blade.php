<!-- resources/views/profile/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Role Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Role & Permissions') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Your current roles and permissions in the system.') }}
                        </p>
                    </header>

                    <div class="mt-6 space-y-6">
                        <!-- Roles -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('Your Roles') }}</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @forelse(auth()->user()->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-gray-500">{{ __('No roles assigned') }}</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('Your Permissions') }}</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @forelse(auth()->user()->getAllPermissions() as $permission)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-gray-500">{{ __('No permissions assigned') }}</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
