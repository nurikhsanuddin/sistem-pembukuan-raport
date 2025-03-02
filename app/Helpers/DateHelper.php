<?php

namespace App\Helpers;

class DateHelper
{
    public static function getIndonesianMonth($month)
    {
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $months[$month] ?? $month;
    }

    public static function formatIndonesianDate($date)
    {
        $date = date('d F Y', strtotime($date));
        $month = date('F', strtotime($date));
        return date('d', strtotime($date)) . ' ' . self::getIndonesianMonth($month) . ' ' . date('Y', strtotime($date));
    }
}

if (!function_exists('formatIndonesianDate')) {
    /**
     * Format date to Indonesian format
     *
     * @param string $format Format date yang diinginkan
     * @param string|null $date Date yang akan diformat (null = current date)
     * @return string
     */
    function formatIndonesianDate($format, $date = null)
    {
        if ($date === null) {
            $date = now();
        }

        $date = is_string($date) ? \Carbon\Carbon::parse($date) : $date;

        $indonesianMonths = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $indonesianDays = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        $day = $date->day;
        $month = $indonesianMonths[$date->month - 1];
        $year = $date->year;
        $dayOfWeek = $indonesianDays[$date->dayOfWeek];

        $result = str_replace(
            ['d', 'F', 'Y', 'l'],
            [$day, $month, $year, $dayOfWeek],
            $format
        );

        return $result;
    }
}
