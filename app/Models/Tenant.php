<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'fname',
        'eid',
        'eidexp',
        'nationality',
        'email',
        'mobile',
        'visa',
        'passportno',
        'passexp',
        'eidfront',
        'eidback',
        'frontpass',
        'backpass',
        'visa_img'
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
