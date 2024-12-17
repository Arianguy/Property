<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::where('validity', 'YES')
            ->with(['tenant', 'property'])
            ->paginate(10);
        return view('transactions.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Contract $contract)
    {
        return view('transactions.create', compact('contract'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'paytype' => 'required|in:CASH,CHEQUE',
            'cheqno' => 'required_if:paytype,CHEQUE',
            'cheqbank' => 'required_if:paytype,CHEQUE',
            'cheqamt' => 'required|numeric|min:0',
            'cheqdate' => 'required|date',
            'trans_type' => 'required|in:RENT,SECURITY',
            'narration' => 'nullable|string',
            'depositdate' => 'nullable|date',
            'cheqstatus' => 'required|in:PENDING,DEPOSITED,BOUNCED',
            'depositac' => 'nullable|string',
            'remarks' => 'nullable|string',
            'cheq_img.*' => 'required_if:paytype,CHEQUE|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        try {
            $transaction = new Transaction($validated);
            $transaction->contract_id = $contract->id;
            $transaction->save();

            // Handle cheque image upload
            if ($request->hasFile('cheq_img')) {
                foreach ($request->file('cheq_img') as $file) {
                    $transaction->addMedia($file)
                        ->toMediaCollection('cheque_images');
                }
            }

            return redirect()
                ->route('contracts.show', $contract->id)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            Log::error('Error recording payment: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to record payment.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
