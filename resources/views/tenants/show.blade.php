<div class="p-4 sm:p-6">
    <!-- Property Header -->
    <div class="mb-4 pb-3 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">{{ $tenant->fname }}</h3>
    </div>
    <div>
         <!-- Tenant Information -->
         <div>
            <div class="bg-white shadow rounded-lg p-4">
                {{-- <h4 class="text-lg font-medium text-gray-700 mb-4"><center>Tenant Details</h4> --}}
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Nationality:</span>
                        <span class="text-gray-900">{{ $tenant->nationality }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Email:</span>
                        <span class="text-gray-900">{{ $tenant->email }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Mobile:</span>
                        <span class="text-gray-900">{{ $tenant->mobile }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Passport:</span>
                        <span class="text-gray-900">{{ $tenant->passportno }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Visa Company:</span>
                        <span class="text-gray-900">{{ $tenant->visa }}</span>
                    </div>

                </div>
                <div class="mt-6">
                    @can('view tenants')
                    <h4 class="text-lg font-medium text-gray-700 mb-4">Emirates ID Documents</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($tenant->getMedia('emirates_ids') as $media)
                            <div class="relative group">
                                @if(Str::contains($media->mime_type, 'image'))
                                    <!-- Image Preview -->
                                    <img src="{{ $media->getUrl() }}"
                                         alt="Emirates ID Document"
                                         class="w-full h-48 object-cover rounded-lg shadow-sm">
                                @else
                                    <!-- PDF Preview -->
                                    <div class="w-full h-48 bg-gray-100 rounded-lg shadow-sm flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Hover Actions -->
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center space-x-2">
                                    <!-- View Button -->
                                    <a href="{{ route('tenants.documents.view', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'emirates']) }}"
                                        target="_blank"
                                        class="bg-white text-gray-800 px-3 py-1 rounded-md text-sm hover:bg-gray-100 transition-colors duration-200">
                                         View
                                     </a>

                                    <!-- Download Button -->
                                    <a href="{{ route('tenants.documents.download', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'emirates']) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600 transition-colors duration-200">
                                         Download
                                     </a>
                                </div>

                                <!-- File Name -->
                                <div class="mt-2 text-sm text-gray-600 truncate">
                                    {{ $media->file_name }}
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-4 text-gray-500">
                                No Emirates ID documents uploaded yet.
                            </div>
                        @endforelse
                    </div>
                    @endcan
                    <div class="mt-6">
                        @can('view tenants')
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Passport Documents</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($tenant->getMedia('passport_copies') as $media)
                                <div class="relative group">
                                    @if(Str::contains($media->mime_type, 'image'))
                                        <img src="{{ $media->getUrl() }}"
                                             alt="Passport Document"
                                             class="w-full h-48 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-lg shadow-sm flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center space-x-2">
                                        <a href="{{ route('tenants.documents.view', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'passport']) }}"
                                            target="_blank"
                                            class="bg-white text-gray-800 px-3 py-1 rounded-md text-sm hover:bg-gray-100 transition-colors duration-200">
                                             View
                                         </a>
                                         <a href="{{ route('tenants.documents.download', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'passport_copies']) }}"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600 transition-colors duration-200">
                                            Download
                                        </a>
                                    </div>

                                    <div class="mt-2 text-sm text-gray-600 truncate">
                                        {{ $media->file_name }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-4 text-gray-500">
                                    No Passport documents uploaded yet.
                                </div>
                            @endforelse
                        </div>
                        @endcan
                    </div>

                    <div class="mt-6">
                        @can('view tenants')
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Visa Documents</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($tenant->getMedia('visa_copies') as $media)
                                <div class="relative group">
                                    @if(Str::contains($media->mime_type, 'image'))
                                        <img src="{{ $media->getUrl() }}"
                                             alt="Visa Document"
                                             class="w-full h-48 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-lg shadow-sm flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center space-x-2">
                                        <a href="{{ route('tenants.documents.view', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'visa']) }}"
                                            target="_blank"
                                            class="bg-white text-gray-800 px-3 py-1 rounded-md text-sm hover:bg-gray-100 transition-colors duration-200">
                                             View
                                         </a>
                                        <a href="{{ route('tenants.documents.download', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'visa_copies']) }}"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600 transition-colors duration-200">
                                             Download
                                         </a>
                                    </div>

                                    <div class="mt-2 text-sm text-gray-600 truncate">
                                        {{ $media->file_name }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-4 text-gray-500">
                                    No Visa documents uploaded yet.
                                </div>
                            @endforelse
                        </div>
                        @endcan
                    </div>

            </div>
        </div>
    </div>
</div>
