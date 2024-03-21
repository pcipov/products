<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function addToHistory(Request $request)
    {
        $cookie = $request->input('cookie');
        $search = $request->input('search');
        if ( $history = History::where('cookie', $cookie)->where('search', $search)->first() ) {
            History::where('cookie', $cookie)->where('search', $search)->update(['updated_at' => now()]);
        } else {
            History::create(['cookie' => $cookie, 'search' => $search]);
        }
    }

    public function getHistory(Request $request)
    {
        $cookie = $request->input('cookie');
        $history = History::where('cookie', $cookie)->orderBy('search')->get()->toArray();
        array_unshift($history, [0=>'']);
        return response()->json($history, 200);
    }
}
