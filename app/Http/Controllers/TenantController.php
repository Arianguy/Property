<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::paginate(10);
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        // Show the form for creating a new tenant
        return view('tenants.create');
    }

    public function store(Request $request)
    {
        // Validate the request data with custom messages
        $request->validate([
            'fname' => 'required|string|max:255',
            'eid' => 'required|numeric|digits:15|unique:tenants,eid', // Ensure it's exactly 15 digits
            'nationality' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|digits:10',
            'visa' => 'required|string|max:255',
            'passportno' => 'required|string|max:255',
        ], [
            'eid.required' => 'The Emirates ID is required.',
            'eid.numeric' => 'The Emirates ID must be a number.',
            'eid.digits' => 'The Emirates ID must be exactly 10 digits long.',
            'eid.unique' => 'The Emirates ID has already been taken.',
            'mobile.required' => 'The Mobile Number is required.',
            'mobile.string' => 'The Mobile Number must be a string.',
            'mobile.digits_between' => 'The Mobile Number must be between 10 and 15 digits long.',
            // Add custom messages for other fields as needed
        ]);

        // Format the Emirates ID
        $formattedEid = $this->formatEmiratesID($request->eid);

        try {
            // Create a new tenant with the formatted Emirates ID
            $tenant = Tenant::create(array_merge($request->all(), ['eid' => $formattedEid]));

            // Redirect to the tenants index with a success message
            return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle the unique constraint violation
            if ($e->getCode() === '23000') {
                return redirect()->back()->withInput()->withErrors(['eid' => 'The Emirates ID has already been taken.']);
            }

            // Handle other database exceptions
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the tenant.']);
        }
    }

    private function formatEmiratesID($eid)
    {
        // Log the raw eid value received
        \Log::info('Raw Emirates ID received for formatting: ' . $eid);

        \Log::info('Cleaned Emirates ID: ' . $eid);

        // Check the length of the cleaned ID
        $length = strlen($eid);

        // Ensure the ID is 15 digits long for the desired format
        if ($length === 15) {
            // Format the Emirates ID for 15 digits
            return substr($eid, 0, 3) . '-' . // First 3 digits
                substr($eid, 3, 4) . '-' .     // Next 4 digits
                substr($eid, 7, 7) . '-' .     // Next 7 digits
                substr($eid, 14, 1);           // Last digit (only 1 digit)
        }

        // Log a warning if the length is incorrect
        \Log::warning('Emirates ID length is not 15 digits: ' . $eid);

        // Return the original ID if it doesn't match the expected lengths
        return $eid;
    }


    public function show($id)
    {
        $tenant = Tenant::findOrFail($id); // Fetch the tenant by ID
        return view('tenants.show', compact('tenant')); // Return the view with tenant data
    }

    public function edit(Tenant $tenant)
    {
        // Fetch the tenant data and return the edit view
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        // Prepare validation rules
        $rules = [
            'fname' => 'required|string|max:255',
            'eid' => 'required|string|size:18|regex:/^\d{3}-\d{4}-\d{7}-\d{1}$/', // Ensure it's in the correct format
            'nationality' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|numeric|digits:10',
            'visa' => 'required|string|max:255',
            'passportno' => 'required|string|max:255',
        ];

        // Add unique validation only if the eid has changed
        if ($request->eid !== $tenant->eid) {
            $rules['eid'] .= '|unique:tenants,eid';
        }

        // Validate the request data with custom messages
        $request->validate($rules, [
            'eid.required' => 'The Emirates ID is required.',
            'eid.string' => 'The Emirates ID must be a string.',
            'eid.size' => 'The Emirates ID must be exactly 18 characters long.',
            'eid.regex' => 'The Emirates ID must be numbers in the format xxx-xxxx-xxxxxxx-x.',
            'eid.unique' => 'The Emirates ID has already been taken.',
            'mobile.digits' => 'The Mobile Number must be exactly 10 digits long.',
            // Add custom messages for other fields as needed
        ]);

        // Format the Emirates ID
        $formattedEid = $this->formatEmiratesID($request->eid);

        // Update the tenant with the validated data
        $tenant->update(array_merge($request->all(), ['eid' => $formattedEid]));

        // Redirect to the tenants index with a success message
        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        try {
            // Delete the tenant
            $tenant->delete();

            // Redirect to the tenants index with a success message
            return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors that may occur during deletion
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the tenant.']);
        }
    }
}
