<?php

namespace App\Models;

use App\Models\Owner;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sales_deed')
            ->useDisk('private')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();  // Only one sales deed per property
    }
    protected $fillable = [

        'name',
        'class',
        'type',
        'purchase_date',
        'title_deed_no',
        'mortgage_status',
        'community',
        'plot_no',
        'bldg_no',
        'bldg_name',
        'property_no',
        'floor_detail',
        'suite_area',
        'balcony_area',
        'area_sq_mter',
        'common_area',
        'area_sq_feet',
        'owner_id',
        'purchase_value',
        'dewa_premise_no',
        'dewa_ac_no',
        'status',
        'salesdeed',
        'is_visible'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
