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

        return ($result === false || empty($result)) ? $result : reset($result);
    }

    public static function cleanPosition($position)
    {
        switch ($position) {
            case 'G_1b':
                return 'first baseman';
            case 'G_2b':
                return 'second baseman';
            case 'G_3b':
                return 'third baseman';
            case 'G_c':
                return 'catcher';
            case 'G_lf':
                return 'left fielder';
            case 'G_rf':
                return 'right fielder';
            case 'G_ss':
                return 'shortstop';
            case 'G_cf':
                return 'center fielder';
            case 'G_ph':
                return 'pitch hitter';
            default:
                return false;
        }
    }
}