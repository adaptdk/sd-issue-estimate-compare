<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-14
 * Time: 21:38
 */

namespace App\model;


use App\Service\timeConverter;

class issue
{

    public $id;

    public $key;

    public $linked;

    public $estimate;

    public $linkedAggregatedEstimate;


    public function __construct($id, $key, $linked = [], $estimate)
    {
        $this->id = $id;
        $this->key = $key;
        $this->linked = $linked;
        $this->estimate = timeConverter::secondsToHours($estimate);

        if (!empty($linked)) {
           $aggregated = 0;

           foreach ($linked as $link) {
               $aggregated = $aggregated + $link->estimate;
           }
           $this->linkedAggregatedEstimate = $aggregated;
        }
    }
}