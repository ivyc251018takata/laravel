<?php

use App\Http\Controllers\PartyController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $organizerToken = $request->cookie('organizer_token');
    $participantId = $request->cookie('participant_id');

    $organizerParty = null;
    $participant = null;

    if ($organizerToken) {
        $organizerParty = \App\Models\Party::where(
            'organizer_token',
            $organizerToken
        )->first();
    }

    if ($participantId) {
        $participant = \App\Models\Participant::find(
            $participantId
        );
    }

    return view('home', [
        'organizerParty' => $organizerParty,
        'participant' => $participant,
    ]);
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

Route::get('/organizer/participants', [ParticipantController::class, 'organizerIndex'])
    ->name('organizer.participants.index');

Route::get(
    '/organizer/participants/{participant}/orders',
    [OrderController::class, 'organizerParticipantOrders']
)->name('organizer.participants.orders');

// 注文
Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('orders.create');

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store');

Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index');

Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
    ->name('orders.destroy');

Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])
    ->name('orders.edit');

Route::put('/orders/{order}', [OrderController::class, 'update'])
    ->name('orders.update');

Route::get('/organizer/orders', [OrderController::class, 'organizerIndex'])
    ->name('organizer.orders.index');

Route::post('/organizer/orders/{order}/approve', [OrderController::class, 'approve'])
    ->name('organizer.orders.approve');

Route::post('/organizer/orders/{order}/reject', [OrderController::class, 'reject'])
    ->name('organizer.orders.reject');