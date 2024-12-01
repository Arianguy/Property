<!-- resources/views/admin/roles/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles Management') }}
            </h2>
            <a href="{{ route('admin.roles.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Role
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Desktop Table (hidden on mobile) -->
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Role Name</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Permissions</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $role->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($role->permissions as $permission)
                                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                               class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                                            @if($role->name !== 'Super Admin')
                                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                                      method="POST"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards (shown only on mobile) -->
                    <div class="md:hidden space-y-6">
                        @foreach ($roles as $role)
                            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                                <div class="p-4">
                                    <!-- Role Header -->
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $role->name }}
                                        </h3>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                               class="inline-flex items-center px-3 py-1 border border-indigo-500 text-indigo-500 rounded-md hover:bg-indigo-500 hover:text-white transition-colors">
                                                Edit
                                            </a>
                                            @if($role->name !== 'Super Admin')
                                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                                      method="POST"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-red-500 text-red-500 rounded-md hover:bg-red-500 hover:text-white transition-colors"
                                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Permissions Section -->
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">
                                            Permissions
                                        </h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($role->permissions as $permission)
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
