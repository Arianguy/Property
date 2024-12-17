<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Record Payment for Contract: ') . $contract->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transactions.store', $contract->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Payment Details</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Payment Type -->
                                <div>
                                    <label for="paytype" class="block text-sm font-medium text-gray-700">Payment Type</label>
                                    <select name="paytype" id="paytype" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="CHEQUE">Cheque</option>
                                        <option value="CASH">Cash</option>
                                    </select>
                                </div>

                                <!-- Cheque Details (shown/hidden based on payment type) -->
                                <div class="cheque-fields">
                                    <div>
                                        <label for="cheqno" class="block text-sm font-medium text-gray-700">Cheque Number</label>
                                        <input type="text" name="cheqno" id="cheqno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="cheqbank" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                        <input type="text" name="cheqbank" id="cheqbank" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div>
                                    <label for="cheqamt" class="block text-sm font-medium text-gray-700">Amount</label>
                                    <input type="number" step="0.01" name="cheqamt" id="cheqamt" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Cheque Date -->
                                <div>
                                    <label for="cheqdate" class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="cheqdate" id="cheqdate" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Transaction Type -->
                                <div>
                                    <label for="trans_type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
                                    <select name="trans_type" id="trans_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="RENT">Rent</option>
                                        <option value="SECURITY">Security Deposit</option>
                                    </select>
                                </div>

                                <!-- Cheque Image -->
                                <div class="cheque-fields">
                                    <label for="cheq_img" class="block text-sm font-medium text-gray-700">Cheque Image</label>
                                    <input type="file" name="cheq_img[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Remarks -->
                                <div class="col-span-3">
                                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea name="remarks" id="remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('paytype').addEventListener('change', function() {
            const chequeFields = document.querySelectorAll('.cheque-fields');
            chequeFields.forEach(field => {
                field.style.display = this.value === 'CHEQUE' ? 'block' : 'none';
            });
        });
    </script>
    @endpush
</x-app-layout>
