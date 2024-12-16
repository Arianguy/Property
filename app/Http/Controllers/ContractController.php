<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ContractController extends Controller
{
    /**
     * Display a listing of the contracts.
     */
    public function index()
    {
        $contracts = Contract::with(['tenant', 'property'])->paginate(10);
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new contract.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $properties = Property::all();
        $randomName = $this->generateUniqueRandomName();
        return view('contracts.create', compact('tenants', 'properties', 'randomName'));
    }

    /**
     * Store a newly created contract in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'property_id' => 'required|exists:properties,id',
            'cstart' => 'required|date|before:cend',
            'cend' => 'required|date|after:cstart',
            'amount' => 'required|numeric|min:0',
            'sec_amt' => 'required|numeric|min:0',
            'ejari' => 'required|string|max:255',
            'validity' => 'required|string|max:255',
        ]);

        // Generate a unique random name
        $randomName = $this->generateUniqueRandomName();

        // Create the contract with the generated name
        $contract = Contract::create(array_merge($validated, ['name' => $randomName]));

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
    }

    private function generateUniqueRandomName($length = 5)
    {
        $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789'; // Define the character set
        $randomName = '';
        $attempts = 0;
        $maxAttempts = 10; // Limit the number of attempts to avoid infinite loops

        do {
            $randomName = '';
            for ($i = 0; $i < $length; $i++) {
                $randomName .= $characters[rand(0, strlen($characters) - 1)]; // Randomly select characters
            }
            $attempts++;
        } while (Contract::where('name', $randomName)->exists() && $attempts < $maxAttempts);

        if ($attempts === $maxAttempts) {
            throw new \Exception('Unable to generate a unique random name after multiple attempts.');
        }

        return $randomName;
    }

    /**
     * Display the specified contract.
     */
    public function show(Contract $contract)
    {
        // Eager load immediate relationships
        $contract->load(['tenant', 'property', 'renewals.tenant', 'renewals.property', 'media']);

        // Fetch all renewals recursively
        $allRenewals = $contract->allRenewals();

        // Fetch all ancestors recursively
        $allAncestors = $contract->allAncestors();

        // Log the number of renewals fetched
        Log::info('Renewals fetched for Contract:', [
            'contract_id' => $contract->id,
            'renewal_count' => $allRenewals->count()
        ]);

        // Log the number of ancestors fetched
        Log::info('Ancestors fetched for Contract:', [
            'contract_id' => $contract->id,
            'ancestor_count' => $allAncestors->count()
        ]);

        return view('contracts.show', compact('contract', 'allRenewals', 'allAncestors'));
    }

    /**
     * Show the form for editing the specified contract.
     */
    public function edit(Contract $contract)
    {
        $tenants = Tenant::all();
        $properties = Property::all();
        return view('contracts.edit', compact('contract', 'tenants', 'properties'));
    }

    /**
     * Update the specified contract in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'property_id' => 'required|exists:properties,id',
            'cstart' => 'required|date|before:cend',
            'cend' => 'required|date|after:cstart',
            'amount' => 'required|numeric|min:0',
            'sec_amt' => 'required|numeric|min:0',
            'ejari' => 'nullable|boolean',
            'validity' => 'nullable|boolean',
        ], [
            'cstart.before' => 'The contract start date must be before the end date.',
            'cend.after' => 'The contract end date must be after the start date.',
        ]);

        // Retrieve the contract
        $contract = Contract::findOrFail($id);

        // Check if the contract is active
        if ($contract->validity !== 'YES') {
            return redirect()->back()->with('error', 'You cannot edit a terminated or renewed contract.');
        }

        // Check if the contract has been renewed
        if ($contract->renewals()->exists()) {
            // If renewed, force validity to 'NO'
            $contract->validity = 'NO';
        } else {
            // Otherwise, set based on the checkbox
            $contract->validity = $request->has('validity') ? 'YES' : 'NO';
        }

        // Set the Ejari value based on the toggle state
        $contract->ejari = $request->has('ejari') ? 'YES' : 'NO';

        // Save other fields as needed
        $contract->tenant_id = $request->tenant_id;
        $contract->property_id = $request->property_id;
        $contract->cstart = $request->cstart;
        $contract->cend = $request->cend;
        $contract->amount = $request->amount;
        $contract->sec_amt = $request->sec_amt;

        // Save the contract
        $contract->save();

        // Handle the file uploads for contract attachments
        if ($request->hasFile('cont_copy')) {
            // Remove existing files in the media collection
            $contract->clearMediaCollection('contracts_copy');

            foreach ($request->file('cont_copy') as $file) {
                $contract->addMedia($file)
                    ->toMediaCollection('contracts_copy'); // Specify the media collection name
            }
        }

        // Redirect or return response
        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
    }

    /**
     * Remove the specified contract from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
    }

    public function viewDocument($contractId, $mediaId)
    {
        $contract = Contract::findOrFail($contractId);

        // Check if the user has permission to view contracts
        if (!auth()->user()->can('view contracts')) {
            abort(403);
        }

        // Retrieve the media associated with the contract
        $media = $contract->getMedia('contracts_copy')->where('id', $mediaId)->firstOrFail();

        // Return the file response
        return response()->file($media->getPath());
    }

    public function downloadDocument($contractId, $mediaId)
    {
        $contract = Contract::findOrFail($contractId);

        // Check if the user has permission to view contracts
        if (!auth()->user()->can('view contracts')) {
            abort(403, 'You do not have permission to view contracts.');
        }

        // Retrieve the media associated with the contract from the specific collection
        $media = $contract->getMedia('contracts_copy')->where('id', $mediaId)->first();

        // Log the media retrieval attempt
        \Log::info('Attempting to download media', [
            'contract_id' => $contractId,
            'media_id' => $mediaId,
            'media_found' => $media ? true : false,
        ]);

        // Check if the media item exists
        if (!$media) {
            \Log::error('Media item not found for Contract ID: ' . $contractId . ' and Media ID: ' . $mediaId);
            abort(404, 'Media item not found');
        }

        // Return the file download response
        return response()->download($media->getPath(), $media->file_name);
    }

    public function renewalList()
    {
        \Log::info('Accessing renewalList method', [
            'url'    => request()->fullUrl(),
            'method' => request()->method()
        ]);

        try {
            $validContracts = Contract::where('validity', 'YES')
                ->whereDoesntHave('renewals')
                ->with(['tenant', 'property'])
                ->paginate(10);

            return view('contracts.renewal-list', compact('validContracts'));
        } catch (\Exception $e) {
            \Log::error('Error in renewalList: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Show the form for renewing the specified contract.
     */
    public function renewForm(Contract $contract)
    {
        // Load the relationships
        $contract->load(['tenant', 'property']);

        // Generate a new contract number
        $newContractName = $this->generateUniqueRandomName();

        // Calculate suggested new dates
        $suggestedStartDate = Carbon::parse($contract->cend)->addDay();
        $suggestedEndDate = Carbon::parse($suggestedStartDate)->addYear()->subDay();

        // Pass the existing tenant and property details along with the new contract name
        return view('contracts.renew', compact('contract', 'suggestedStartDate', 'suggestedEndDate', 'newContractName'));
    }

    /**
     * Process the renewal of the specified contract.
     */
    public function processRenewal(Request $request, Contract $contract)
    {
        try {
            // Validate the renewal request
            $validated = $request->validate([
                'cstart'     => 'required|date|after:' . $contract->cend,
                'cend'       => 'required|date|after:cstart',
                'amount'     => 'required|numeric|min:0',
                'sec_amt'    => 'required|numeric|min:0',
                'ejari'      => 'required|string|max:255',
                'validity'   => 'required|string|max:255',
                // Add other validation rules as necessary
            ]);

            // Generate a unique contract name
            $newContractName = $this->generateUniqueRandomName();

            // Create a new contract instance for the renewal
            $newContract = new Contract();
            $newContract->name = $newContractName;
            $newContract->tenant_id = $contract->tenant_id;
            $newContract->property_id = $contract->property_id;
            $newContract->cstart = $validated['cstart'];
            $newContract->cend = $validated['cend'];
            $newContract->amount = $validated['amount'];
            $newContract->sec_amt = $validated['sec_amt'];
            $newContract->ejari = $validated['ejari'] == '1' ? 'YES' : 'NO';
            $newContract->validity = $validated['validity'] == '1' ? 'YES' : 'NO';
            $newContract->type = 'renewed';
            $newContract->previous_contract_id = $contract->id;

            // Save the new contract
            $newContract->save();

            // Handle the file uploads for contract attachments
            if ($request->hasFile('cont_copy')) {
                foreach ($request->file('cont_copy') as $file) {
                    $newContract->addMedia($file)
                        ->toMediaCollection('contracts_copy');
                }
            }

            // Set the validity of the previous contract to 'NO'
            $contract->update(['validity' => 'NO']);

            // Update the property's status to 'LEASED'
            $newContract->property->update(['status' => 'LEASED']);

            // Redirect to the contract show page with success message
            return redirect()->route('contracts.show', $newContract->id)
                ->with('success', 'Contract renewed successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error during Contract Renewal:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected Error during Contract Renewal:', $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while renewing the contract.');
        }
    }

    /**
     * Terminate the specified contract.
     */
    public function terminate($id)
    {
        try {
            $contract = Contract::findOrFail($id);
            $contract->update(['validity' => 'NO']);

            // Update the property's status to 'VACANT'
            $contract->property->update(['status' => 'VACANT']);

            Log::info('Contract terminated successfully.', ['contract_id' => $id]);

            return redirect()->route('contracts.index')->with('success', 'Contract terminated successfully.');
        } catch (\Exception $e) {
            Log::error('Error terminating contract: ' . $e->getMessage(), ['contract_id' => $id]);
            return redirect()->back()->with('error', 'Failed to terminate the contract.');
        }
    }

    /**
     * Download a media file associated with a contract.
     */
    public function downloadMedia($contractId, $mediaId)
    {
        $contract = Contract::findOrFail($contractId);

        // Retrieve the media associated with the contract from the specific collection
        $media = $contract->getMedia('contracts_copy')->where('id', $mediaId)->first();

        // Log the media retrieval attempt
        Log::info('Attempting to download media', [
            'contract_id' => $contractId,
            'media_id' => $mediaId,
            'media_found' => $media ? true : false,
        ]);

        // Check if the media item exists
        if (!$media) {
            Log::error('Media item not found for Contract ID: ' . $contractId . ' and Media ID: ' . $mediaId);
            abort(404, 'Media item not found');
        }

        // Return the file download response
        return response()->download($media->getPath(), $media->file_name);
    }
}
