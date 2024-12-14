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
                    <form id="renewal-form" action="{{ route('contracts.process-renewal', $contract->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
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
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Contract Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- New Contract Name (Read-Only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">New Contract Name</label>
                                    <input type="text" value="{{ $newContractName }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" />
                                </div>

                                <!-- Tenant Information (Read-Only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tenant</label>
                                    <input type="text" value="{{ $contract->tenant->fname }} ({{ $contract->tenant->eid }})" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" />
                                </div>

                                <!-- Property Information (Read-Only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Property</label>
                                    <input type="text" value="{{ $contract->property->name }} ({{ $contract->property->community }})" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" />
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <label for="cstart" class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <input type="date" name="cstart" id="cstart" value="{{ old('cstart', $suggestedStartDate->toDateString()) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('cstart')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="cend" class="block text-sm font-medium text-gray-700">End Date</label>
                                    <input type="date" name="cend" id="cend" value="{{ old('cend', $suggestedEndDate->toDateString()) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('cend')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Contract Amount -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Contract Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $contract->amount) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('amount')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Security Amount -->
                                <div>
                                    <label for="sec_amt" class="block text-sm font-medium text-gray-700">Security Amount</label>
                                    <input type="number" step="0.01" name="sec_amt" id="sec_amt" value="{{ old('sec_amt', $contract->sec_amt) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('sec_amt')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ejari and Validity -->
                                <div class="flex space-x-4">
                                    <div>
                                        <label for="ejari" class="block text-sm font-medium text-gray-700">Ejari</label>
                                        <label class="inline-flex items-center">
                                            <!-- Hidden input to send '0' when checkbox is unchecked -->
                                            <input type="hidden" name="ejari" value="0">
                                            <input type="checkbox" name="ejari" id="ejari" value="1" {{ old('ejari', $contract->ejari) === 'YES' ? 'checked' : '' }} class="hidden">
                                            <span class="toggle-switch"></span>
                                        </label>
                                        @error('ejari')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="validity" class="block text-sm font-medium text-gray-700">Validity</label>
                                        <!-- Hidden input to ensure 'validity' is submitted -->
                                        <input type="hidden" name="validity" value="1">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" id="validity_display" checked disabled class="hidden">
                                            <span class="toggle-switch"></span>
                                        </label>
                                        @error('validity')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Attach Signed Contract -->
                                <div>
                                    <label for="cont_copy" class="block text-sm font-medium text-gray-700">Attach Signed Contract</label>
                                    <input type="file" name="cont_copy[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('cont_copy')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-3">
                            <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Reset Form
                            </button>
                            <button type="submit" id="submit-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit Renewal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
            background-color: #ccc;
            border-radius: 34px;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .toggle-switch:before {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.2s;
        }

        input:checked + .toggle-switch {
            background-color: #4CAF50; /* Change color when checked */
        }

        input:checked + .toggle-switch:before {
            transform: translateX(14px); /* Move the switch when checked */
        }
    </style>

    <!-- JavaScript to Disable Submit Button After Click -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('renewal-form');
            const submitButton = document.getElementById('submit-button');

            form.addEventListener('submit', function () {
                // Disable the submit button to prevent multiple submissions
                submitButton.disabled = true;
                submitButton.innerText = 'Submitting...';
            });
        });
    </script>
</x-app-layout>
