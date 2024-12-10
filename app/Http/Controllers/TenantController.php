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
            'passexp' => 'required|date|max:255',
            'eidexp' => 'required|date|max:255',
            'emirates_id.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
            'passport_copy.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'visa_copy.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [], [
            'eid.required' => 'The Emirates ID is required.',
            'eid.numeric' => 'The Emirates ID must be a number.',
            'eid.digits' => 'The Emirates ID must be exactly 15 digits long.',
            'eid.unique' => 'The Emirates ID has already been taken.',
            'mobile.required' => 'The Mobile Number is required.',
            'mobile.string' => 'The Mobile Number must be a string.',
            'mobile.digits' => 'The Mobile Number must be exactly 10 digits long.',
            'emirates_id.*.required' => 'Each Emirates ID file is required.', // Custom message for file requirement
            'passport_copy.*.required' => 'Each Passport copy file is required.',
            'visa_copy.*.required' => 'Each Visa copy file is required.',
        ]);

        // Format the Emirates ID
        $formattedEid = $this->formatEmiratesID($request->eid);

        try {
            // Create a new tenant with the formatted Emirates ID
            $tenant = Tenant::create(array_merge($request->all(), ['eid' => $formattedEid]));

            // Handle the file uploads
            // Handle multiple file uploads for emirates_id
            if ($request->hasFile('emirates_id')) {
                foreach ($request->file('emirates_id') as $file) {
                    $tenant->addMedia($file)
                        ->toMediaCollection('emirates_ids');
                    Log::info('File uploaded successfully: ' . $file->getClientOriginalName());
                }
            } else {
                Log::warning('No files uploaded for Emirates ID.');
            }

            // Handle Passport copy files
            if ($request->hasFile('passport_copy')) {
                foreach ($request->file('passport_copy') as $file) {
                    $tenant->addMedia($file)->toMediaCollection('passport_copies');
                }
            }

            // Handle Visa copy files
            if ($request->hasFile('visa_copy')) {
                foreach ($request->file('visa_copy') as $file) {
                    $tenant->addMedia($file)->toMediaCollection('visa_copies');
                }
            }

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
        'Log'::info('Raw Emirates ID received for formatting: ' . $eid);

        'Log'::info('Cleaned Emirates ID: ' . $eid);

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
        'Log'::warning('Emirates ID length is not 15 digits: ' . $eid);

        // Return the original ID if it doesn't match the expected lengths
        return $eid;
    }

    public function viewDocument($tenantId, $mediaId, $type)
    {
        $tenant = Tenant::findOrFail($tenantId);

        if (!auth()->user()->can('view tenants')) {
            abort(403);
        }

        $collectionName = $this->getCollectionName($type);
        $media = $tenant->getMedia($collectionName)->where('id', $mediaId)->firstOrFail();

        return response()->file($media->getPath());
    }

    public function downloadDocument($tenantId, $mediaId, $type)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $media = $tenant->getMedia($type)->where('id', $mediaId)->first();

        if (!$media) {
            abort(404, 'Media item not found');
        }

        return response()->download($media->getPath(), $media->file_name);
    }

    private function getCollectionName($type)
    {
        return match ($type) {
            'passport' => 'passport_copies',
            'visa' => 'visa_copies',
            default => 'emirates_ids',
        };
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
        // Log the incoming request data
        Log::info('Update method called for tenant ID: ' . $tenant->id);
        Log::info('Request data: ', $request->all());

        // Prepare validation rules
        $rules = [
            'fname' => 'required|string|max:255',
            'eid' => 'required|string|size:18|regex:/^\d{3}-\d{4}-\d{7}-\d{1}$/', // Ensure it's in the correct format
            'nationality' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|numeric|digits:10',
            'visa' => 'required|string|max:255',
            'passportno' => 'required|string|max:255',
            'emirates_id.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validate each file as required
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
            'emirates_id.*.required' => 'Each Emirates ID file is required.', // Custom message for file requirement
        ]);

        // Format the Emirates ID
        $formattedEid = $this->formatEmiratesID($request->eid);

        // Update the tenant with the validated data
        $tenant->update(array_merge($request->all(), ['eid' => $formattedEid]));

        // Handle Emirates ID files
        if ($request->hasFile('emirates_id')) {
            // Clear existing emirates_ids media collection
            $tenant->clearMediaCollection('emirates_ids');

            foreach ($request->file('emirates_id') as $file) {
                if ($file->isValid()) {
                    $tenant->addMedia($file)
                        ->toMediaCollection('emirates_ids');
                    Log::info('File uploaded successfully: ' . $file->getClientOriginalName());
                }
            }
        } else {
            Log::warning('No files uploaded for Emirates ID.');
        }

        // Handle Passport copy files
        if ($request->hasFile('passport_copy')) {
            // Clear existing passport_copies media collection
            $tenant->clearMediaCollection('passport_copies');

            foreach ($request->file('passport_copy') as $file) {
                if ($file->isValid()) {
                    $tenant->addMedia($file)
                        ->sanitizingFileName(function ($fileName) {
                            return str_replace(['#', '/', '\\'], '-', $fileName);
                        })
                        ->toMediaCollection('passport_copies');
                }
            }
        } else {
            Log::warning('No files uploaded for Passport.');
        }

        // Handle Visa copy files
        if ($request->hasFile('visa_copy')) {
            // Clear existing visa_copies media collection
            $tenant->clearMediaCollection('visa_copies');

            foreach ($request->file('visa_copy') as $file) {
                if ($file->isValid()) {
                    $tenant->addMedia($file)
                        ->sanitizingFileName(function ($fileName) {
                            return str_replace(['#', '/', '\\'], '-', $fileName);
                        })
                        ->toMediaCollection('visa_copies');
                }
            }
        } else {
            Log::warning('No files uploaded for Visa.');
        }


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
