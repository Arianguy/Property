<div class="p-4 sm:p-6">
    <!-- Property Header -->
    <div class="mb-4 pb-3 border-b">
        <h3 class="text-2xl font-semibold text-gray-800">{{ $property->name }}</h3>
       <span class="text-sm">
    Status:
    <span class="inline-block px-2 py-1 text-xs font-medium rounded
        {{ strtolower($property->status) === 'leased' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
        {{ ucfirst($property->status) }}
    </span>
</span>
    </div>

    <!-- Property Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div>
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Basic Information</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Class:</span>
                        <span class="text-gray-900">{{ $property->class }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Type:</span>
                        <span class="text-gray-900">{{ $property->type }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Community:</span>
                        <span class="text-gray-900">{{ $property->community }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Owner:</span>
                        <span class="text-gray-900">{{ $property->owner->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Mortgage Status:</span>
                        <span class="text-gray-900">{{ ucfirst($property->mortgage_status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div>
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Location Details</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Plot No:</span>
                        <span class="text-gray-900">{{ $property->plot_no }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Building No:</span>
                        <span class="text-gray-900">{{ $property->bldg_no }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Building Name:</span>
                        <span class="text-gray-900">{{ $property->bldg_name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Floor Detail:</span>
                        <span class="text-gray-900">{{ $property->floor_detail }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Property No:</span>
                        <span class="text-gray-900">{{ $property->property_no }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Information -->
        <div>
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Area Details</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Suite Area:</span>
                        <span class="text-gray-900">{{ $property->suite_area }} sq m</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Balcony Area:</span>
                        <span class="text-gray-900">{{ $property->balcony_area }} sq m</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Common Area:</span>
                        <span class="text-gray-900">{{ $property->common_area }} sq m</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Area:</span>
                        <span class="text-gray-900">{{ $property->area_sq_mter }} sq m ({{ $property->area_sq_feet }} sq ft)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <div>
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Financial Details</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Purchase Value:</span>
                        <span class="text-gray-900">AED {{ number_format($property->purchase_value, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Purchase Date:</span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($property->purchase_date)->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Title Deed No:</span>
                        <span class="text-gray-900">{{ $property->title_deed_no }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utility Information -->
        <div>
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Utility Information</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">DEWA Premise No:</span>
                        <span class="text-gray-900">{{ $property->dewa_premise_no ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">DEWA Account No:</span>
                        <span class="text-gray-900">{{ $property->dewa_account_no ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visibility -->
        <div>
            <div class="bg-white shadow rounded-lg p-4">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Visibility</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Visible to Public:</span>
                        <span class="text-gray-900">{{ $property->is_visible ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Download Sales Deed:</span>
                        @if($property->getFirstMedia('salesdeed'))
                            <a href="{{ route('properties.downloadSalesDeed', $property->id) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Download
                            </a>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Available
                            </span>
                     @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
