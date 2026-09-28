<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\RejectOrderRequest;
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

    public function organizerCreate(Request $request): View
    {
        $party = \App\Models\Party::where(
            'organizer_token',
            $request->cookie('organizer_token')
        )->firstOrFail();

        return view('orders.organizer_create');
    }

    public function index(Request $request): View
    {
        $participantId = $request->cookie('participant_id');

        $orders = Order::where('participant_id', $participantId)
            ->latest()
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
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

    public function organizerStore(StoreOrderRequest $request): RedirectResponse
    {
        $party = \App\Models\Party::where(
            'organizer_token',
            $request->cookie('organizer_token')
        )->firstOrFail();

        $participant = Participant::firstOrCreate([
            'party_id' => $party->id,
            'nickname' => '幹事',
        ]);

        Order::create([
            'participant_id' => $participant->id,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'memo' => $request->memo,
            'status' => 0,
        ]);

        return redirect()->route('organizer.orders.index');
    }

    public function destroy(Request $request, Order $order): RedirectResponse
    {
        $participantId = $request->cookie('participant_id');

        if ($order->participant_id != $participantId) {
            abort(403);
        }

        $order->delete();

        return redirect()->route('orders.index');
    }

    public function edit(Request $request, Order $order): View
    {
        $participantId = $request->cookie('participant_id');

        if ($order->participant_id != $participantId) {
            abort(403);
        }

        return view('orders.edit', [
            'order' => $order,
        ]);
    }

    public function update(
        StoreOrderRequest $request,
        Order $order
    ): RedirectResponse {
        $participantId = $request->cookie('participant_id');

        if ($order->participant_id != $participantId) {
            abort(403);
        }

        $order->update([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'memo' => $request->memo,
            'status' => 0,
            'reject_reason' => null,
        ]);

        return redirect()->route('orders.index');
    }

    public function organizerIndex(Request $request): View
    {
        $organizerToken = $request->cookie('organizer_token');

        $party = \App\Models\Party::where(
            'organizer_token',
            $organizerToken
        )->firstOrFail();

        $participants = Participant::where(
            'party_id',
            $party->id
        )
        ->latest()
        ->get();

        // この宴会の注文
        $orders = Order::whereHas('participant', function ($query) use ($party) {
            $query->where('party_id', $party->id);
        })
        ->with('participant')
        ->latest()
        ->get();

        // 宴会全体の合計金額
        $totalAmount = $orders->sum(function ($order) {
            if ($order->unit_price === null) {
                return 0;
            }

            return $order->quantity * $order->unit_price;
        });

        // 承認済み注文だけの合計金額
        $approvedAmount = $orders
            ->where('status', 1)
            ->sum(function ($order) {
                if ($order->unit_price === null) {
                    return 0;
                }

                return $order->quantity * $order->unit_price;
            });

        // 参加者ごとの合計金額
        $participantTotals = $orders
            ->groupBy('participant_id')
            ->map(function ($participantOrders) {
                return $participantOrders->sum(function ($order) {
                    if ($order->unit_price === null) {
                        return 0;
                    }

                    return $order->quantity * $order->unit_price;
                });
            });

            // 単価が未設定の注文
        $unpricedOrders = $orders->filter(function ($order) {
            return $order->unit_price === null;
        });

        $pendingCount = $orders->where('status', 0)->count();
        $approvedCount = $orders->where('status', 1)->count();
        $rejectedCount = $orders->where('status', 2)->count();

        return view('orders.organizer', [
            'party' => $party,
            'participants' => $participants,
            'orders' => $orders,
            'totalAmount' => $totalAmount,
            'approvedAmount' => $approvedAmount,
            'participantTotals' => $participantTotals,
            'unpricedOrders' => $unpricedOrders,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }

    public function organizerParticipantOrders(
        Request $request,
        Participant $participant
    ): View {
        $organizerToken = $request->cookie('organizer_token');

        $party = \App\Models\Party::where(
            'organizer_token',
            $organizerToken
        )->firstOrFail();

        // その参加者が、この幹事の宴会に所属しているか確認
        if ($participant->party_id != $party->id) {
            abort(403);
        }

        $orders = Order::where(
            'participant_id',
            $participant->id
        )
        ->latest()
        ->get();

        return view('orders.organizer_participant', [
            'party' => $party,
            'participant' => $participant,
            'orders' => $orders,
        ]);
    }

    public function approve(Request $request, Order $order): RedirectResponse
    {
        $organizerToken = $request->cookie('organizer_token');

        $party = \App\Models\Party::where(
            'organizer_token',
            $organizerToken
        )->firstOrFail();

        if ($order->participant->party_id != $party->id) {
            abort(403);
        }

        $order->update([
            'status' => 1,
            'reject_reason' => null,
        ]);

        return redirect()->route('organizer.orders.index');
    }

    public function reject(
        RejectOrderRequest $request,
        Order $order
    ): RedirectResponse {
        $organizerToken = $request->cookie('organizer_token');

        $party = \App\Models\Party::where(
            'organizer_token',
            $organizerToken
        )->firstOrFail();

        if ($order->participant->party_id != $party->id) {
            abort(403);
        }

        $order->update([
            'status' => 2,
            'reject_reason' => $request->reject_reason,
        ]);

        return redirect()->route('organizer.orders.index');
    }
}