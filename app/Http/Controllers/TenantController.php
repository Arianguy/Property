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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show the form for creating a new tenant
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data with custom messages
        $request->validate([
            'fname' => 'required|string|max:255',
            'eid' => 'required|numeric|digits:15|unique:tenants,eid', // Ensure it's exactly 15 digits
            'nationality' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required||numeric|digits:10',
            'visa' => 'required|string|max:255',
            'passportno' => 'required|string|max:255',
        ], [
            'eid.required' => 'The Emirates ID is required.',
            'eid.numeric' => 'The Emirates ID must be a number.',
            'eid.digits' => 'The Emirates ID must be exactly 15 digits long.',
            'eid.unique' => 'The Emirates ID has already been taken.',
            'mobile.digits' => 'The Mobile Number must be exactly 10 digits long.',
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
                return redirect()->back()->withErrors(['eid' => 'The Emirates ID has already been taken.']);
            }

            // Handle other database exceptions
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the tenant.']);
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


    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
