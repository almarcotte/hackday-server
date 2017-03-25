<?php

namespace App;


class Player
{
    /**
     * @param $player
     *
     * @return mixed
     */
    public static function findByName($player)
    {
        $result = app('db')->select(
            "select * from Master where CONCAT_WS(' ', nameFirst, nameLast) = ? or nameGiven = ? limit 1",
            [$player, $player]
        );

        return reset($result);
    }
}