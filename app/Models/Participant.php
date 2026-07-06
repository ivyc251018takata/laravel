<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = [
    'party_id',
    'nickname',
    'memo',
];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}