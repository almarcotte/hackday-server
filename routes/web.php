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
    $count = app('db')->select("SELECT count(*) as count FROM Master");
    
    return reset($count)->count;
});

$app->get('/{player}', function ($player) use ($app) {
    return [Player::findByName(urldecode($player))];
});