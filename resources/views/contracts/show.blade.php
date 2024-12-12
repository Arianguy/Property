<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Contract Details') }}
            </h2>
            <a href="{{ route('contracts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <!-- Contract Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contract Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Contract No:</span>
                                <span class="text-gray-900">{{ $contract->name }}</span>
                            </div>
                            {{-- {{-- <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Tenant:</span>
                                <span class="text-gray-900">{{ $contract->tenant->fname }} ({{ $contract->tenant->eid }})</span>
                            </div> --}}
                            {{-- <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Property:</span>
                                <span class="text-gray-900">{{ $contract->property->name }} ({{ $contract->property->community }})</span>
                            </div> --}}
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Start Date:</span>
                                <span class="text-gray-900">{{ $contract->cstart }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">End Date:</span>
                                <span class="text-gray-900">{{ $contract->cend }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">RentAmount:</span>
                                <span class="text-gray-900">{{ number_format($contract->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Security Amount:</span>
                                <span class="text-gray-900">{{ number_format($contract->sec_amt, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Ejari made :</span>
                                <span class="text-gray-900">{{ $contract->ejari }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Validity:</span>
                                <span class="text-gray-900">{{ $contract->validity }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Related Tenant Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tenant Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Full Name:</span>
                                <span class="text-gray-900">{{ $contract->tenant->fname }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Emirates ID:</span>
                                <span class="text-gray-900">{{ $contract->tenant->eid }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Mobile No:</span>
                                <span class="text-gray-900">{{ $contract->tenant->mobile }}</span>
                            </div>
                            <!-- Add more tenant details as needed -->
                        </div>
                    </div>

                    <!-- Related Property Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Property Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Property Name:</span>
                                <span class="text-gray-900">{{ $contract->property->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Community:</span>
                                <span class="text-gray-900">{{ $contract->property->community }}</span>
                            </div>
                            <!-- Add more property details as needed -->
                        </div>
                    </div>

                    <!-- Attached Files -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Attached Files</h3>
                        <div class="space-y-3">
                            @forelse($contract->getMedia('contracts_copy') as $media)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-900">{{ $media->file_name }}</span>
                                <span>
                                    @if(in_array($media->extension, ['jpg', 'jpeg', 'png']))
                                        <a href="{{ route('contracts.documents.view', ['contract' => $contract->id, 'media' => $media->id]) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                    @endif
                                    <a href="{{ route('contracts.documents.download', ['contract' => $contract->id, 'media' => $media->id]) }}" class="text-blue-600 hover:text-blue-900 ml-2">Download</a>
                                </span>
                            </div>
                            @empty
                                <div class="text-center py-2 text-gray-500">No documents uploaded yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
