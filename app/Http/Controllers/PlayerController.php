<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function handle(Request $request)
    {
        $player = $request->json('player');

        return response()->json([
            'player' => $player,
            'metric' => 'RBI',
            'filters' => [
                'Comicbook Name',
                'Born in New York, NY',
                'Born in 1978',
                'Left handed'
            ]
        ]);
    }
}