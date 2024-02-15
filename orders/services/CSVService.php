<?php

namespace orders\services;

use Yii;

class CSVService
{
    public static function createCSV($query, $coldefs, $csvFileName = null, $separator = ';')
    {
        $returnVal = '';
        $r = '';
        foreach ($coldefs as $col => $config) {
            $r .= $col.$separator;
            $item = trim(rtrim($r, $separator)).PHP_EOL;
        }
        $returnVal .= $item;
        foreach ($query->batch(10000) as $rowArr) {
            foreach ($rowArr as $row) {
                $r = '';
                foreach ($coldefs as $col => $config) {

                    if (isset($row[$col])) {

                        $val = $row[$col];

                        foreach ($config as $conf) {
                            if (! empty($conf)) {
                                $val = Yii::$app->formatter->format($val, $conf);
                            }
                        }

                        $r .= $val.$separator;
                    }
                }
                $item = trim(rtrim($r, $separator)).PHP_EOL;
                $returnVal .= $item;
            }
        }

        return $returnVal;
    }
}
