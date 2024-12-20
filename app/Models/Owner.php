<?php

namespace App\Models;

use App\Models\Property;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
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
