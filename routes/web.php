<?php

use App\Http\Controllers\PartyController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// 幹事
Route::get('/parties/create', [PartyController::class, 'create'])
    ->name('parties.create');
    
Route::post('/parties', [PartyController::class, 'store'])
    ->name('parties.store');

// 参加者
Route::get('/join', [ParticipantController::class, 'create'])
    ->name('participants.create');

Route::post('/join', [ParticipantController::class, 'store'])
    ->name('participants.store');

// 注文
Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('orders.create');

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store');