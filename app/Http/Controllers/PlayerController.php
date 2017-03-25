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
                ? "Born in " . (isset($qualifiers['state']) ? $qualifiers['state'] . ',' : 'the') . " USA"
                : "Born in {$qualifiers['country']}";

            if (isset($qualifiers['month'])) {
                $birth .= ' in ' . (\DateTime::createFromFormat('!m', $qualifiers['month']))->format('F');
            }

            $filters[] = $birth;
        }

        $position = $participation->position != 'other' ? Player::cleanPosition($participation->position) : null;

        // try and find a fun fact

        $fun_fact = app('db')->select("select * from fun_facts where playerID = '$playerID'");

        if ($fun_fact !== false) {
            $fun_fact = reset($fun_fact);
            $fun_fact = $fun_fact->phrase == 'NA' ? false : $fun_fact->phrase;
        }

        return response()->json([
            'player' => $player,
            'position' => $position,
            'fun_fact' => $fun_fact,
            'metric' => "$metric in $year",
            'filters' => $filters,
            'full' => $obj,
        ]);
    }
}