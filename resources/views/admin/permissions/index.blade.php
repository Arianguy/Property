<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions Management') }}
            </h2>
            <a href="{{ route('admin.permissions.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Permission
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, permissionToDelete: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Responsive Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($groupedPermissions as $module => $permissions)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <!-- Module Header -->
                        <div class="bg-gradient-to-r {{ $moduleColors[$module] ?? 'from-gray-500 to-gray-600' }} p-4">
                            <h3 class="text-lg font-semibold text-white capitalize flex items-center justify-between">
                                <span>{{ ucfirst($module) }}</span>
                                <span class="text-sm bg-white bg-opacity-20 px-2 py-1 rounded-full">
                                    {{ $permissions->count() }}
                                </span>
                            </h3>
                        </div>

                        <!-- Permissions List -->
                        <div class="divide-y divide-gray-200">
                            @foreach($permissions as $permission)
                                <div class="p-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <div class="text-sm font-medium text-gray-700 capitalize truncate">
                                            {{ str_replace([$module . '_', '_'], ['', ' '], $permission->name) }}
                                        </div>
                                        <div class="flex space-x-2 items-center">
                                            <a href="{{ route('admin.permissions.edit', $permission) }}"
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-100">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
