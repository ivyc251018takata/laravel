<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}