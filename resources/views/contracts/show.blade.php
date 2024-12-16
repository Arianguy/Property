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
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Start Date:</span>
                                <span class="text-gray-900">{{ $contract->cstart }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">End Date:</span>
                                <span class="text-gray-900">{{ $contract->cend }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Rent Amount:</span>
                                <span class="text-gray-900">{{ number_format($contract->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Security Amount:</span>
                                <span class="text-gray-900">{{ number_format($contract->sec_amt, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Ejari Made:</span>
                                <span class="text-gray-900">{{ $contract->ejari }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Validity:</span>
                                <span class="text-gray-900">{{ $contract->validity }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Renewal History -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Renewal History</h3>
                        @if($allRenewals->isEmpty())
                            <p class="text-gray-500">No renewals for this contract.</p>
                        @else
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr class="text-left text-gray-600 text-sm font-medium">
                                        <th class="py-2 px-4 border-b">Contract No</th>
                                        <th class="py-2 px-4 border-b">Start Date</th>
                                        <th class="py-2 px-4 border-b">End Date</th>
                                        <th class="py-2 px-4 border-b">Rent Amount</th>
                                        <th class="py-2 px-4 border-b">Security Amount</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allRenewals as $renewal)
                                        <tr class="text-gray-700 text-sm hover:bg-gray-50">
                                            <td class="py-2 px-4 border-b">{{ $renewal->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $renewal->cstart }}</td>
                                            <td class="py-2 px-4 border-b">{{ $renewal->cend }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($renewal->amount, 2) }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($renewal->sec_amt, 2) }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('contracts.show', $renewal->id) }}"
                                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Previous Contracts -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Previous Contracts</h3>
                        @if($allAncestors->isEmpty())
                            <p class="text-gray-500">This is the original contract.</p>
                        @else
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr class="text-left text-gray-600 text-sm font-medium">
                                        <th class="py-2 px-4 border-b">Contract No</th>
                                        <th class="py-2 px-4 border-b">Start Date</th>
                                        <th class="py-2 px-4 border-b">End Date</th>
                                        <th class="py-2 px-4 border-b">Rent Amount</th>
                                        <th class="py-2 px-4 border-b">Security Amount</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allAncestors as $ancestor)
                                        <tr class="text-gray-700 text-sm hover:bg-gray-50">
                                            <td class="py-2 px-4 border-b">{{ $ancestor->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $ancestor->cstart }}</td>
                                            <td class="py-2 px-4 border-b">{{ $ancestor->cend }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($ancestor->amount, 2) }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($ancestor->sec_amt, 2) }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('contracts.show', $ancestor->id) }}"
                                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
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
                                        @if(in_array(strtolower($media->extension), ['jpg', 'jpeg', 'png']))
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
