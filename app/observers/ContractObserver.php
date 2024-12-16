<?php

namespace App\Observers;

use App\Models\Contract;

class ContractObserver
{
    /**
     * Handle the Contract "created" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function created(Contract $contract)
    {
        // When a new contract is created (fresh or renewed), set the property's status to LEASED
        $contract->property->update(['status' => 'LEASED']);
    }

    /**
     * Handle the Contract "updated" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function updated(Contract $contract)
    {
        // If the contract's validity has been set to 'YES', ensure the property's status is 'LEASED'
        if ($contract->validity === 'YES') {
            $contract->property->update(['status' => 'LEASED']);
        }

        // Optionally, handle status updates when a contract is terminated
        if ($contract->wasChanged('validity') && $contract->validity === 'NO') {
            // Check if there are no other active contracts for the property
            $activeContracts = Contract::where('property_id', $contract->property_id)
                ->where('validity', 'YES')
                ->count();

            if ($activeContracts === 0) {
                $contract->property->update(['status' => 'VACANT']);
            }
        }
    }

    /**
     * Handle the Contract "deleted" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function deleted(Contract $contract)
    {
        // When a contract is deleted, check if there are other active contracts for the property
        $activeContracts = Contract::where('property_id', $contract->property_id)
            ->where('validity', 'YES')
            ->count();

        if ($activeContracts === 0) {
            $contract->property->update(['status' => 'VACANT']);
        }
    }
}
