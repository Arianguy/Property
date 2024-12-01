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

    <div class="py-12">
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
                            @foreach($permissions->sortBy(function($permission) {
                                $actions = ['view' => 1, 'create' => 2, 'edit' => 3, 'delete' => 4, 'manage' => 5];
                                foreach($actions as $action => $order) {
                                    if(str_contains($permission->name, $action)) {
                                        return $order;
                                    }
                                }
                                return 6;
                            }) as $permission)
                                <div class="p-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <div class="flex items-center space-x-3 min-w-0">
                                            <!-- Permission Type Indicator and Name -->
                                            @if(str_contains($permission->name, 'view'))
                                                <div class="flex items-center space-x-2 min-w-0">
                                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-green-500"></span>
                                                    <span class="text-sm font-medium text-gray-700 capitalize truncate flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        <span class="truncate">{{ str_replace([$module . '_', '_'], ['', ' '], $permission->name) }}</span>
                                                    </span>
                                                </div>
                                            @elseif(str_contains($permission->name, 'create'))
                                                <!-- Similar structure for create -->
                                                <div class="flex items-center space-x-2 min-w-0">
                                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-blue-500"></span>
                                                    <span class="text-sm font-medium text-gray-700 capitalize truncate flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                        </svg>
                                                        <span class="truncate">{{ str_replace([$module . '_', '_'], ['', ' '], $permission->name) }}</span>
                                                    </span>
                                                </div>
                                            @elseif(str_contains($permission->name, 'edit'))
                                                <!-- Similar structure for edit -->
                                                <div class="flex items-center space-x-2 min-w-0">
                                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-yellow-500"></span>
                                                    <span class="text-sm font-medium text-gray-700 capitalize truncate flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                        </svg>
                                                        <span class="truncate">{{ str_replace([$module . '_', '_'], ['', ' '], $permission->name) }}</span>
                                                    </span>
                                                </div>
                                            @else
                                                <!-- Similar structure for other types -->
                                                <div class="flex items-center space-x-2 min-w-0">
                                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-500"></span>
                                                    <span class="text-sm font-medium text-gray-700 capitalize truncate flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                        </svg>
                                                        <span class="truncate">{{ str_replace([$module . '_', '_'], ['', ' '], $permission->name) }}</span>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex space-x-2 items-center">
                                            <a href="{{ route('admin.permissions.edit', $permission) }}"
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <button type="button"
                                                    @click="showDeleteModal = true; permissionToDelete = '{{ $permission->id }}'"
                                                    class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
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

    <!-- Delete Modal -->
    <div x-data="{ showDeleteModal: false, permissionToDelete: null }"
         @keydown.escape.window="showDeleteModal = false"
         x-cloak>
        <template x-if="showDeleteModal">
            <div class="fixed inset-0 flex items-center justify-center z-50 px-4 sm:px-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-900 opacity-50"></div>

                <!-- Modal -->
                <div class="relative bg-white rounded-lg w-full max-w-md z-50" @click.away="showDeleteModal = false">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Confirm Delete
                        </h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Are you sure you want to delete this permission? This action cannot be undone.
                        </p>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button @click="showDeleteModal = false"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Cancel
                            </button>
                            <form :action="'/admin/permissions/' + permissionToDelete"
                                  method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
