<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        $contract->load(['tenant', 'property', 'media']);
        return view('contracts.show', compact('contract'));
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

        // Set the values based on the toggle state
        $contract->ejari = $request->has('ejari') ? 'YES' : 'NO';
        $contract->validity = $request->has('validity') ? 'YES' : 'NO';

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
        \Log::info('renewalList method started');

        // Check if view file exists
        $viewPath = resource_path('views/contracts/renewal-list.blade.php');
        \Log::info('View file exists: ' . (file_exists($viewPath) ? 'Yes' : 'No'), [
            'path' => $viewPath
        ]);

        try {
            // Log the SQL query
            \DB::enableQueryLog();

            $validContracts = Contract::where(function ($query) {
                $query->where('type', 'fresh')
                    ->orWhereDoesntHave('renewals');
            })
                ->with(['tenant', 'property'])
                ->paginate(10);

            // Log the executed query
            \Log::info('Query executed:', [
                'sql' => \DB::getQueryLog(),
                'contract_count' => $validContracts->count()
            ]);

            \Log::info('Attempting to render view: contracts.renewal-list');

            return view('contracts.renewal-list', compact('validContracts'));
        } catch (\Exception $e) {
            \Log::error('Error in renewalList: ', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function renewForm(Contract $contract)
    {
        // Load the relationships
        $contract->load(['tenant', 'property']);

        // Calculate suggested new dates
        $suggestedStartDate = Carbon::parse($contract->cend)->addDay();
        $suggestedEndDate = Carbon::parse($suggestedStartDate)->addYear();

        return view('contracts.renew', compact('contract', 'suggestedStartDate', 'suggestedEndDate'));
    }

    public function processRenewal(Request $request, Contract $contract)
    {
        // Validate the renewal request
        $validated = $request->validate([
            'cstart' => 'required|date|after:' . $contract->cend,
            'cend' => 'required|date|after:cstart',
            'amount' => 'required|numeric|min:0',
            'sec_amt' => 'required|numeric|min:0',
            'ejari' => 'required|string|max:255',
            'validity' => 'required|string|max:255',
        ]);

        // Generate a new contract number
        $newContractName = $this->generateUniqueRandomName();

        // Create new contract with existing tenant and property
        $newContract = Contract::create([
            'name' => $newContractName,
            'tenant_id' => $contract->tenant_id,
            'property_id' => $contract->property_id,
            'cstart' => $validated['cstart'],
            'cend' => $validated['cend'],
            'amount' => $validated['amount'],
            'sec_amt' => $validated['sec_amt'],
            'ejari' => $validated['ejari'],
            'validity' => $validated['validity'],
            'type' => 'renewed',
            'previous_contract_id' => $contract->id
        ]);

        return redirect()->route('contracts.show', $newContract)
            ->with('success', 'Contract renewed successfully.');
    }
}
