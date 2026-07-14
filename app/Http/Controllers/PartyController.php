<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartyRequest;
use App\Models\Party;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PartyController extends Controller
{
    public function create()
    {
        return view('parties.create');
    }
    public function store(StorePartyRequest $request)
    {
        $party = Party::create([
            'name' => $request->name,
            'join_code' => strtoupper(Str::random(6)),
            'organizer_token' => Str::uuid(),
            'table_number' => $request->table_number,
            'memo' => $request->memo,
        ]);

        //まだ幹事用画面を作っていないので、一時的に宴会作成画面へ戻す
        return redirect()->route('parties.create');
        // return redirect('/')
        //     ->cookie(
        //         'organizer_token',
        //         $party->organizer_token,
        //         60 * 24 * 365
        //     );
    }
}
