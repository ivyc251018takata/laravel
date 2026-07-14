<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Models\Participant;
use App\Models\Party;
use Illuminate\Http\RedirectResponse;

class ParticipantController extends Controller
{
    public function create()
    {
        return view('participants.create');
    }

    public function store(StoreParticipantRequest $request): RedirectResponse
    {
        $party = Party::where(
            'join_code',
            strtoupper($request->join_code)
        )->first();

        if (!$party) {
            return back()
                ->withErrors([
                    'join_code' => '参加コードが存在しません。'
                ])
                ->withInput();
        }

        $participant = Participant::create([
            'party_id' => $party->id,
            'nickname' => $request->nickname,
            'memo' => $request->memo,
        ]);

        //後で注文入力画面（G05）が完成したら、そこへのリダイレクトに変更
        return redirect()->route('orders.create')
        ->cookie(
            'participant_id',
            $participant->id,
            60 * 24 * 30
        );
    }
}