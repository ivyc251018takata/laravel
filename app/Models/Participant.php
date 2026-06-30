<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}