<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Contract extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'tenant_id',
        'property_id',
        'cstart',
        'cend',
        'amount',
        'sec_amt',
        'ejari',
        'validity',
        'type',
        'previous_contract_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ejari'    => 'string',
        'validity' => 'string',
        // If you decide to switch to boolean, update accordingly
        // 'ejari'    => 'boolean',
        // 'validity' => 'boolean',
    ];

    /**
     * Get the tenant that owns the contract.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the property that owns the contract.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function previousContract()
    {
        return $this->belongsTo(Contract::class, 'previous_contract_id');
    }

    public function renewals()
    {
        return $this->hasMany(Contract::class, 'previous_contract_id');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                // validation rules
            ]);

            $randomName = $this->generateUniqueRandomName();
            $contract = Contract::create(array_merge($validated, ['name' => $randomName]));

            // Update property status
            $contract->property->update(['status' => 'LEASED']);

            DB::commit();

            return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating contract: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create the contract.');
        }
    }
}
