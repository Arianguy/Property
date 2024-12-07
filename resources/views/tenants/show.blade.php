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
                    {{-- <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Lease Start Date:</span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($property->tenant->lease_start_date)->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Lease End Date:</span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($property->tenant->lease_end_date)->format('d F Y') }}</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
