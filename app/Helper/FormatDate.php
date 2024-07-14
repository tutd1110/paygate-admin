<?php

namespace App\Helper;

use Carbon\Carbon;

class FormatDate
{
    public static function dateTimeLocalClient($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d').'T'
            .\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i');
    }

    /**
     * $dayOfTheWeek = Carbon::now()->dayOfWeek;
     */
    public static function dateOfWeek($dayOfTheWeek)
    {
        $weekMap = [
            0 => 'Chủ nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];

        $weekday = $weekMap[$dayOfTheWeek];

        return $weekday;
    }

    static function dateRange($range)
    {
        $data = explode(' - ', $range);

        try {
            return [
                'beginDate' => Carbon::createFromFormat('d/m/Y', $data[0]),
                'endDate' => Carbon::createFromFormat('d/m/Y', $data[1]),
                'raw' => $range
            ];
        } catch (\Exception $exception) {
            return [
                'beginDate' => Carbon::now()->subMonth(),
                'endDate' => Carbon::now(),
                'raw' => Carbon::now()->subMonth()->format('d/m/Y').' - '.Carbon::now()->format('d/m/Y'),
            ];
        }

    }

    public static function get_start_strtotime($str){
        $tmp = explode('/', $str);
        return mktime(0,0,0,$tmp[1], $tmp[0], $tmp[2]);
    }

    public static function get_end_strtotime($str){
        $tmp = explode('/', $str);
        return mktime(23,59,59,$tmp[1], $tmp[0], $tmp[2]);
    }
}
