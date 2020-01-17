<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-15
 * Time: 19:27
 */

namespace App\service;


class configuration
{
    private $list;

    public function set($id, $value) {
        return $this->list[$id] = $value;
    }

    public function get($id) {

        return $this->list[$id];
    }



}