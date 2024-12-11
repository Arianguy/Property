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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <!-- Contract Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contract Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Name:</span>
                                <span class="text-gray-900">{{ $contract->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Tenant:</span>
                                <span class="text-gray-900">{{ $contract->tenant->fname }} ({{ $contract->tenant->eid }})</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Property:</span>
                                <span class="text-gray-900">{{ $contract->property->name }} ({{ $contract->property->community }})</span>
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
                                <span class="text-gray-500">Amount:</span>
                                <span class="text-gray-900">{{ number_format($contract->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Security Amount:</span>
                                <span class="text-gray-900">{{ number_format($contract->sec_amt, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Ejari:</span>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
