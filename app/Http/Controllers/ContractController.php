<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;

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
        return view('contracts.create', compact('tenants', 'properties'));
    }

    /**
     * Store a newly created contract in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'cstart' => 'required|date|before:cend',
            'cend' => 'required|date|after:cstart',
            'amount' => 'required|numeric|min:0',
            'sec_amt' => 'required|numeric|min:0',
            'ejari' => 'required|string|max:255',
            'validity' => 'required|string|max:255',
        ], [
            'tenant_id.required' => 'The tenant field is required.',
            'tenant_id.exists' => 'The selected tenant is invalid.',
            'property_id.required' => 'The property field is required.',
            'property_id.exists' => 'The selected property is invalid.',
            'cstart.before' => 'The contract start date must be before the end date.',
            'cend.after' => 'The contract end date must be after the start date.',
        ]);

        Contract::create($validated);

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
    }

    /**
     * Display the specified contract.
     */
    public function show(Contract $contract)
    {
        $contract->load(['tenant', 'property']);
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
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'cstart' => 'required|date|before:cend',
            'cend' => 'required|date|after:cstart',
            'amount' => 'required|numeric|min:0',
            'sec_amt' => 'required|numeric|min:0',
            'ejari' => 'required|string|max:255',
            'validity' => 'required|string|max:255',
        ], [
            'tenant_id.required' => 'The tenant field is required.',
            'tenant_id.exists' => 'The selected tenant is invalid.',
            'property_id.required' => 'The property field is required.',
            'property_id.exists' => 'The selected property is invalid.',
            'cstart.before' => 'The contract start date must be before the end date.',
            'cend.after' => 'The contract end date must be after the start date.',
        ]);

        $contract->update($validated);

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
}
