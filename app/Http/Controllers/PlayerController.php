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

        $playerID = $obj->playerID;

        $participation = app('db')->select("select * from participation_awards where playerID = '$playerID'");

        if ($participation === false) {
            return response()->json(['error' => "Couldn't find a trophy for $player"]);
        }

        $participation = reset($participation);

        $metric = $participation->category;
        $year = $participation->yearID;
        $qualifiers = json_decode($participation->qualifiers, true);

        $filters = [];

        if (isset($qualifiers['country'])) {
            $birth = $qualifiers['country'] == 'USA'
                ? "Born in {$qualifiers['state']}, USA"
                : "Born in {$qualifiers['country']}";

            if (isset($qualifiers['month'])) {
                $birth .= ' in ' . (\DateTime::createFromFormat('!m', $qualifiers['month']))->format('F');
            }

            $filters[] = $birth;
        }

        $position = $participation->position != 'other' ? Player::cleanPosition($participation->position) : null;

        return response()->json([
            'player' => $player,
            'position' => $position,
            'metric' => "$metric in $year",
            'filters' => $filters,
            'full' => $obj,
        ]);
    }
}