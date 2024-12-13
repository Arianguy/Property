<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Renew Contract') }} - {{ $contract->name }}
            </h2>
            <a href="{{ route('contracts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Previous Contract Details -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Previous Contract Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Previous Start Date: {{ $contract->cstart }}</p>
                                <p class="text-sm text-gray-600">Previous End Date: {{ $contract->cend }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Previous Amount: {{ number_format($contract->amount, 2) }}</p>
                                <p class="text-sm text-gray-600">Previous Security Deposit: {{ number_format($contract->sec_amt, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Renewal Form -->
                    <form action="{{ route('contracts.process-renewal', $contract->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        <!-- Add your form fields here -->
                        <!-- Similar to create form but with pre-filled tenant and property -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
