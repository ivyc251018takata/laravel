<?php

use App\Http\Controllers\PartyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PartyController::class, 'create']);
Route::post('/parties', [PartyController::class, 'store'])
    ->name('parties.store');