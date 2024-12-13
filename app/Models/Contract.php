<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
