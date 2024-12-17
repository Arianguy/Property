<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'contract_id',
        'paytype',
        'cheqno',
        'cheqbank',
        'cheqamt',
        'cheqdate',
        'trans_type',
        'narration',
        'depositdate',
        'cheqstatus',
        'depositac',
        'remarks',
    ];

    public function Contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
