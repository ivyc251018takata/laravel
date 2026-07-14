<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'participant_id',
        'item_name',
        'quantity',
        'unit_price',
        'memo',
        'status',
        'reject_reason',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}