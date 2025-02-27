<?php

namespace App\Helper;

class OptionSelectHelpers
{
    public static array $genders = [
        'Pria' => 'Pria',
        'Wanita' => 'Wanita',
    ];

    public static array $religion = [
        'Islam' => 'Islam',
        'Kristen' => 'Kristen',
        'Katholik' => 'Katholik',
        'Hindu' => 'Hindu',
        'Budha' => 'Budha',
        'Konghucu' => 'Konghucu',
    ];

    public static array $addressType = [
        "Sesuai KTP" => "Sesuai KTP",
        "Domisili" => "Domisili",
    ];

    public static array $salaryComponentTypes = [
        0 => 'Potongan',
        1 => 'Pendapatan',
    ];
}
