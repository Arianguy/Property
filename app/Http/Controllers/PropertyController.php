<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('owner')->orderBy('ID')->paginate(40);
        return view('properties.index', compact('properties'));
    }


    public function create()
    {
        $owners = Owner::all(['id', 'name']);

        // Return the view with owners data
        return view('properties.create', compact('owners'));
    }

    public function show($id)
    {
        // Fetch the property by its ID
        $property = Property::with('owner')->findOrFail($id);


        // Get sales deed if exists
        $salesDeed = $property->getFirstMedia('sales_deed');
        $salesDeedUrl = $salesDeed
            ? route('properties.sales-deed', $property->id)
            : null;

        // If it's an AJAX request, return without the layout
        if (request()->ajax()) {
            return view('properties.show-modal', compact('property', 'salesDeedUrl'));
        }

        // Regular request with full layout
        return view('properties.show', compact('property', 'salesDeedUrl'));
    }

    // Add this method to handle file serving
    public function downloadSalesDeed($id)
    {
        $property = Property::findOrFail($id);

        // Check authorization
        if (!auth()->user()->can('view', $property)) {
            abort(403);
        }

        $media = $property->getFirstMedia('salesdeed');

        if (!$media) {
            abort(404, 'Document not found');
        }

        return response()->file($media->getPath(), [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
            'Cache-Control' => 'private, must-revalidate, max-age=3600'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string',
            'type' => 'required|string',
            'purchase_date' => 'required|date',
            'title_deed_no' => 'required|string',
            'mortgage_status' => 'required|string',
            'community' => 'required|string',
            'plot_no' => 'required|numeric',
            'bldg_no' => 'required|numeric',
            'bldg_name' => 'required|string',
            'property_no' => 'required|string',
            'floor_detail' => 'required|string',
            'suite_area' => 'required|numeric',
            'balcony_area' => 'required|numeric',
            'area_sq_mter' => 'required|numeric',
            'common_area' => 'required|numeric',
            'area_sq_feet' => 'required|numeric',
            'owner_id' => 'required|exists:owners,id',
            'purchase_value' => 'required|numeric',
            'status' => 'required|string',
            'dewa_premise_no' => 'nullable|numeric',
            'dewa_account_no' => 'nullable|numeric',
            'salesdeed' => 'required|mimes:pdf|max:10240', // 10MB max
            'is_visible' => 'boolean'
        ]);
        $propertyData = collect($validated)->except('salesdeed')->toArray();

        // Proceed with storing the property and handling the file upload
        $propertyData = collect($validated)->except('salesdeed')->toArray();
        $property = Property::create($propertyData);

        if ($request->hasFile('salesdeed')) {
            $property->addMedia($request->file('salesdeed'))
                ->toMediaCollection('salesdeed');
        }


        return redirect()
            ->route('properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function edit(Property $property)
    {
        $owners = Owner::all();
        return view('properties.edit', compact('property', 'owners'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string',
            'type' => 'required|string',
            'purchase_date' => 'required|date',
            'title_deed_no' => 'required|string|unique:properties,title_deed_no,' . $id,
            'mortgage_status' => 'required|string',
            'community' => 'required|string',
            'plot_no' => 'required|numeric',
            'bldg_no' => 'required|numeric',
            'bldg_name' => 'required|string',
            'property_no' => 'required|string',
            'floor_detail' => 'required|string',
            'suite_area' => 'required|numeric',
            'balcony_area' => 'required|numeric',
            'area_sq_mter' => 'required|numeric',
            'common_area' => 'required|numeric',
            'area_sq_feet' => 'required|numeric',
            'owner_id' => 'required|exists:owners,id',
            'purchase_value' => 'required|numeric',
            'status' => 'required|string',
            'dewa_premise_no' => 'nullable|numeric',
            'dewa_account_no' => 'nullable|numeric',
            'salesdeed' => 'nullable|mimes:pdf|max:10240', // 10MB max
            'is_visible' => 'boolean'
        ]);

        // Find the existing property by ID
        $property = Property::findOrFail($id);

        // Update the property with validated data, excluding the salesdeed
        $property->fill(collect($validated)->except('salesdeed')->toArray());
        $property->save();

        // Handle the file upload if a new file is provided
        if ($request->hasFile('salesdeed')) {
            // Remove old media if necessary (optional)
            $property->clearMediaCollection('salesdeed');

            // Add the new file to the media collection
            $property->addMedia($request->file('salesdeed'))
                ->toMediaCollection('salesdeed');
        }

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}
