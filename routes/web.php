<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Player;


$app->post('/', 'PlayerController@handle');

$app->get('/', function () use ($app) {
    $players = app('db')->select("select playerID, CONCAT_WS(' ', nameFirst, nameLast) as name from Master order by name");

    return view('index', ['players' => $players]);
});

$app->get('/search', function (\Illuminate\Http\Request $request) use ($app) {
    $name = $request->get('term');

    $players = app('db')->select(
        "select playerID as id, CONCAT_WS(' ', nameFirst, nameLast) as `value` from Master
                where CONCAT_WS(' ', nameFirst, nameLast) like \"%$name%\""
    );

    return $players;
});

$app->get('/{player}', function ($player) use ($app) {
    $player_id = Player::findByName(urldecode($player))->playerID;

    if ($player_id === false) {
        return ['error' => 'No player found'];
    }

    return Player::find($player_id);
});