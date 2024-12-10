<div class="p-4 sm:p-6 overflow-x-auto">
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
                        <span class="text-gray-900">{{ $tenant->passportno }}  (Valid:{{ $tenant->passexp}})</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Visa Company:</span>
                        <span class="text-gray-900">{{ $tenant->visa }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Emirates ID:</span>
                        <span class="text-gray-900">{{ $tenant->eid }}  (Valid:{{ $tenant->eidexp}})</span>
                    </div>

                </div>
                <div class="mt-6">
                    @can('view tenants')
                    <h4 class="text-md font-small text-gray-500 mb-4">Emirates ID Documents</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tenant->getMedia('emirates_ids') as $media)
                                <tr class="text-sm">
                                    <td class="px-4 py-2 whitespace-nowrap">Emirates ID</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $media->file_name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        @if(in_array($media->extension, ['jpg', 'jpeg', 'png']))
                                            <a href="{{ route('tenants.documents.view', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'emirates']) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                        @endif
                                        <a href="{{ route('tenants.documents.download', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'emirates_ids']) }}" class="text-blue-600 hover:text-blue-900 ml-2">Download</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-2 text-gray-500">No Emirates ID documents uploaded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endcan
                    <div class="mt-6 overflow-x-auto">
                        @can('view tenants')
                        <h4 class="text-md font-small text-gray-500 mb-4">Passport Documents</h4>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tenant->getMedia('passport_copies') as $media)
                                    <tr class="text-sm">
                                        <td class="px-4 py-2 whitespace-nowrap">Passport</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $media->file_name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            @if(in_array($media->extension, ['jpg', 'jpeg', 'png']))
                                                <a href="{{ route('tenants.documents.view', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'passport']) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                            @endif
                                            <a href="{{ route('tenants.documents.download', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'passport_copies']) }}" class="text-blue-600 hover:text-blue-900 ml-4">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">No Passport documents uploaded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endcan
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        @can('view tenants')
                        <h4 class="text-md font-small text-gray-500 mb-4">Visa Documents</h4>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tenant->getMedia('visa_copies') as $media)
                                    <tr class="text-sm">
                                        <td class="px-4 py-2 whitespace-nowrap">Visa</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $media->file_name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            @if(in_array($media->extension, ['jpg', 'jpeg', 'png']))
                                                <a href="{{ route('tenants.documents.view', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'visa']) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                            @endif
                                            <a href="{{ route('tenants.documents.download', ['tenant' => $tenant->id, 'media' => $media->id, 'type' => 'visa_copies']) }}" class="text-blue-600 hover:text-blue-900 ml-4">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">No Visa documents uploaded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endcan
                    </div>

            </div>
        </div>
    </div>
</div>
