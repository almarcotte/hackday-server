<?php

namespace App\Http\Controllers;


use App\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function handle(Request $request)
    {
        $player = $request->json('player');

        $obj = Player::findByName($player);

        if ($obj === false) {
            return response()->json(['error' => "No player found for $player"]);
        }

        return response()->json([
            'player' => $player,
            'metric' => 'RBI',
            'full' => $obj,
            'filters' => [
                'Comicbook Name',
                'Born in New York, NY',
                'Born in 1978',
                'Left handed'
            ]
        ]);
    }
}