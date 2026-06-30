<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    protected $fillable = [
    'name',
    'join_code',
    'organizer_token',
    'table_number',
    'memo',
    ];
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}