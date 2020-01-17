<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-15
 * Time: 10:26
 */

namespace App\service;


class htmlLink
{

    public static function renderIssueLink($key) {
        return '<a href="https://sygeforsikringdk.atlassian.net/browse/' . $key . '" target="_blank">' . $key . '</a>';
    }

}