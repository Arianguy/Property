<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Contract') }}
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
                    <form action="{{ route('contracts.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Contract Information -->
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Contract Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Contract Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Contract Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $randomName ?? '') }}" readonly
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring-gray-300 bg-gray-200">
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tenant Selection -->
                                <div>
                                    <label for="tenant_id" class="block text-sm font-medium text-gray-700">Tenant</label>
                                    <div class="flex items-center">
                                    <select name="tenant_id" id="tenant_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Tenant</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->fname }} ({{ $tenant->eid }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('tenants.create') }}" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                                        +
                                    </a>
                                    @error('tenant_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>

                                <!-- Property Selection -->
                                <div>
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                    <select name="property_id" id="property_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            @if($property->status === 'VACANT')
                                                <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                                    {{ $property->name }} ({{ $property->community }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>



                                <!-- Start Date -->
                                <div>
                                    <label for="cstart" class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <input type="date" name="cstart" id="cstart" value="{{ old('cstart') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('cstart')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="cend" class="block text-sm font-medium text-gray-700">End Date</label>
                                    <input type="date" name="cend" id="cend" value="{{ old('cend') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('cend')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Contract Amount -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Contract Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('amount')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Security Amount -->
                                <div>
                                    <label for="sec_amt" class="block text-sm font-medium text-gray-700">Security Amount</label>
                                    <input type="number" step="0.01" name="sec_amt" id="sec_amt" value="{{ old('sec_amt') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('sec_amt')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ejari -->
                                <div>
                                    <label for="ejari" class="block text-sm font-medium text-gray-700">Ejari</label>
                                    <input type="text" name="ejari" id="ejari" value="{{ old('ejari') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('ejari')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Validity -->
                                <div>
                                    <label for="validity" class="block text-sm font-medium text-gray-700"></label>
                                    <input type="hidden" name="validity" id="validity" value="YES"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('validity')
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
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Contract
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
