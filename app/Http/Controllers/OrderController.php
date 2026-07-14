<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(): View
    {
        return view('orders.create');
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $participantId = $request->cookie('participant_id');

        $participant = Participant::findOrFail($participantId);

        Order::create([
            'participant_id' => $participant->id,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'memo' => $request->memo,
            'status' => 0,
        ]);

        return redirect()->route('orders.create');
    }
}