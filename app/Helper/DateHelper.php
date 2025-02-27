<?php

namespace App\Helper;

use Carbon\Carbon;

class DateHelper
{
    public static function calculateYearOfService($joinDate, $leavingDate): string
    {
        if (!$joinDate) {
            return '';
        }
        $joinDate = Carbon::parse($joinDate);
        $now = now();
        if ($leavingDate) {
            $now = Carbon::parse($leavingDate);
        }
        $diff = $joinDate->diff($now);
        $years = $diff->y;
        $months = $diff->m;

        return "{$years} " . __('global.years') . " {$months} " . __('global.months');
    }

    public static function isSunday($value)
    {
        return Carbon::parse($value)->isSunday();
    }

    public static array $months = [
        1 => "Januari",
        2 => "Februari",
        3 => "Maret",
        4 => "April",
        5 => "Mei",
        6 => "Juni",
        7 => "Juli",
        8 => "Agustus",
        9 => "September",
        10 => "Oktober",
        11 => "November",
        12 => "Desember",
    ];

    public static array $years = [
        2010 => "2010",
        2011 => "2011",
        2012 => "2012",
        2013 => "2013",
        2014 => "2014",
        2015 => "2015",
        2016 => "2016",
        2017 => "2017",
        2018 => "2018",
        2019 => "2019",
        2020 => "2020",
        2021 => "2021",
        2022 => "2022",
        2023 => "2023",
        2024 => "2024",
        2025 => "2025",
        2026 => "2026",
        2027 => "2027",
        2028 => "2028",
        2029 => "2029",
        2030 => "2030",
    ];
}
