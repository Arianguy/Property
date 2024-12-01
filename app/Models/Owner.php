<?php

namespace App\Models;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'eid',
        'eidexp',
        'nationality',
        'email',
        'mobile',
        'nakheelno',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
