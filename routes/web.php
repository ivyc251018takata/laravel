<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PartyController;
use Illuminate\Support\Facades\Route;

// 幹事
Route::get('/', [PartyController::class, 'create']);
Route::post('/parties', [PartyController::class, 'store'])
    ->name('parties.store');

// 参加者
Route::get('/join', [ParticipantController::class, 'create'])
    ->name('participants.create');

Route::post('/join', [ParticipantController::class, 'store'])
    ->name('participants.store');