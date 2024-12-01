<!-- resources/views/properties/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Property') }}
            </h2>
            <a href="{{ route('properties.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('properties.update', $property->id) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Property Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Property Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $property->name) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Property Class -->
                                <div>
                                    <label for="class" class="block text-sm font-medium text-gray-700">Property Class</label>
                                    <select name="class" id="class" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Class</option>
                                        <option value="1 BHK" {{ old('class', $property->class) === '1 BHK' ? 'selected' : '' }}>1 BHK</option>
                                        <option value="Commercial" {{ old('class', $property->class) === 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                        <option value="Mixed Use" {{ old('class', $property->class) === 'Mixed Use' ? 'selected' : '' }}>Mixed Use</option>
                                    </select>
                                    @error('class')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Property Type -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Property Type</label>
                                    <select name="type" id="type" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Type</option>
                                        <option value="Residential" {{ old('type', $property->type) === 'Residential' ? 'selected' : '' }}>Residential</option>
                                        <option value="Villa" {{ old('type', $property->type) === 'Villa' ? 'selected' : '' }}>Villa</option>
                                        <option value="Office" {{ old('type', $property->type) === 'Office' ? 'selected' : '' }}>Office</option>
                                        <option value="Retail" {{ old('type', $property->type) === 'Retail' ? 'selected' : '' }}>Retail</option>
                                    </select>
                                    @error('type')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Property Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date</label>
                                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $property->purchase_date) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('purchase_date')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="title_deed_no" class="block text-sm font-medium text-gray-700">Title Deed Number</label>
                                    <input type="text" name="title_deed_no" id="title_deed_no" value="{{ old('title_deed_no', $property->title_deed_no) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('title_deed_no')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="mortgage_status" class="block text-sm font-medium text-gray-700">Mortgage Status</label>
                                    <select name="mortgage_status" id="mortgage_status" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="None" {{ old('mortgage_status', $property->mortgage_status) === 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Mortgaged" {{ old('mortgage_status', $property->mortgage_status) === 'Mortgaged' ? 'selected' : '' }}>Mortgaged</option>
                                        <option value="Released" {{ old('mortgage_status', $property->mortgage_status) === 'Released' ? 'selected' : '' }}>Released</option>
                                    </select>
                                    @error('mortgage_status')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Location Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="community" class="block text-sm font-medium text-gray-700">Community</label>
                                    <input type="text" name="community" id="community" value="{{ old('community', $property->community) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('community')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="plot_no" class="block text-sm font-medium text-gray-700">Plot Number</label>
                                    <input type="number" name="plot_no" id="plot_no" value="{{ old('plot_no', $property->plot_no) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('plot_no')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bldg_no" class="block text-sm font-medium text-gray-700">Building Number</label>
                                    <input type="number" name="bldg_no" id="bldg_no" value="{{ old('bldg_no', $property->bldg_no) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('bldg_no')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bldg_name" class="block text-sm font-medium text-gray-700">Building Name</label>
                                    <input type="text" name="bldg_name" id="bldg_name" value="{{ old('bldg_name', $property->bldg_name) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('bldg_name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="property_no" class="block text-sm font-medium text-gray-700">Property Number</label>
                                    <input type="text" name="property_no" id="property_no" value="{{ old('property_no', $property->property_no) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('property_no')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="floor_detail" class="block text-sm font-medium text-gray-700">Floor Detail</label>
                                    <input type="text" name="floor_detail" id="floor_detail" value="{{ old('floor_detail', $property->floor_detail) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('floor_detail')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Area Information -->
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Area Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="suite_area" class="block text-sm font-medium text-gray-700">Suite Area</label>
                                    <input type="number" step="0.01" name="suite_area" id="suite_area" value="{{ old('suite_area', $property->suite_area) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('suite_area')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="balcony_area" class="block text-sm font-medium text-gray-700">Balcony Area</label>
                                    <input type="number" step="0.01" name="balcony_area" id="balcony_area" value="{{ old('balcony_area', $property->balcony_area) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('balcony_area')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="area_sq_mter" class="block text-sm font-medium text-gray-700">Area (sq. meters)</label>
                                    <input type="number" step="0.01" name="area_sq_mter" id="area_sq_mter" value="{{ old('area_sq_mter', $property->area_sq_mter) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('area_sq_mter')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="common_area" class="block text-sm font-medium text-gray-700">Common Area</label>
                                    <input type="number" step="0.01" name="common_area" id="common_area" value="{{ old('common_area', $property->common_area) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('common_area')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="area_sq_feet" class="block text-sm font-medium text-gray-700">Area (sq. feet)</label>
                                    <input type="number" step="0.01" name="area_sq_feet" id="area_sq_feet" value="{{ old('area_sq_feet', $property->area_sq_feet) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('area_sq_feet')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Financial & Additional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="owner_id" class="block text-sm font-medium text-gray-700">Owner</label>
                                    <select name="owner_id" id="owner_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Owner</option>
                                        @foreach($owners as $owner)
                                            <option value="{{ $owner->id }}" {{ old('owner_id', $property->owner_id) == $owner->id ? 'selected' : '' }}>
                                                {{ $owner->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('owner_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="purchase_value" class="block text-sm font-medium text-gray-700">Purchase Value</label>
                                    <input type="number" name="purchase_value" id="purchase_value" value="{{ old('purchase_value', $property->purchase_value) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('purchase_value')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="VACANT" {{ old('status', $property->status) === 'VACANT' ? 'selected' : '' }}>Vacant</option>
                                        <option value="LEASED" {{ old('status', $property->status) === 'LEASED' ? 'selected' : '' }}>Rented</option>
                                        <option value="Under Maintenance" {{ old('status', $property->status) === 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    </select>
                                    @error('status')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="dewa_premise_no" class="block text-sm font-medium text-gray-700">DEWA Premise No.</label>
                                    <input type="number" name="dewa_premise_no" id="dewa_premise_no" value="{{ old('dewa_premise_no', $property->dewa_premise_no) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('dewa_premise_no')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                        </div>

                                        <div>
                                            <label for="dewa_account_no" class="block text-sm font-medium text-gray-700">DEWA Account No.</label>
                                            <input type="number" name="dewa_account_no" id="dewa_account_no" value="{{ old('dewa_account_no', $property->dewa_account_no) }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @error('dewa_account_no')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pdf_file" class="block text-sm font-medium text-gray-700">Upload PDF</label>
                                            <input type="file" name="salesdeed" id="pdf_file" accept="application/pdf"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @error('salesdeed')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        Reset Form
                                    </button>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Update Property
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-app-layout>
