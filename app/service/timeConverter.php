<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-15
 * Time: 09:15
 */
namespace App\Service;

class timeConverter
{

    const HOUR_SECONDS = 3600;

    public static function secondsToHours($seconds) {
        return $seconds / self::HOUR_SECONDS;
    }
}