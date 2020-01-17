<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-15
 * Time: 09:18
 */

namespace App\service;


class htmlTable
{
    private $head;

    private $rows;

    private $output;

    public function __construct($head = [], $rows = [])
    {
        $this->head = $head;
        $this->rows = $rows;

    }

    public function render() {

        $this->output = [];

        $this->renderHead();

        $this->renderRows();

        return '<table>' . implode("\n", $this->output) . '</table>';

    }

    private function renderHead() {
        $this->output[] = self::renderRow($this->head);
    }

    private function renderRows() {
        foreach ($this->rows as $rowData) {
            $this->output[] = self::renderRow($rowData);
        }
    }

    public static function renderRow($rowData = []) {

        return '<tr><td>' . implode('</td><td>', $rowData) . '</td></tr>';
    }

}