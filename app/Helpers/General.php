<?php

namespace App\Helpers;

class General {
    public static function formatDate($date) {
        return date('d-m-Y', strtotime($date));
    }

    public static function generateSlug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
        return trim($slug, '-');
    }

    public static function GeneratePassword($length = 10)
    {
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        $all = $upper . $lower . $numbers . $symbols;

        // Minimal harus ada 1 dari setiap kategori
        $password = '';
        $password .= $upper[random_int(0, strlen($upper) - 1)];
        $password .= $lower[random_int(0, strlen($lower) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Tambah sisa karakter acak
        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        // Acak urutan karakter
        return str_shuffle($password);
    }

    public static function GetOneDataFromModel($model, array $with, $column, $param){
        return $model::with($with)->where($column, $param)->first();
    }

    public static function Terbilang($angka)
    {
        $angka = abs($angka);
        $baca  = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $hasil = "";

        if ($angka < 12) {
            $hasil = " " . $baca[$angka];
        } elseif ($angka < 20) {
            $hasil = self::Terbilang($angka - 10) . " belas";
        } elseif ($angka < 100) {
            $hasil = self::Terbilang($angka / 10) . " puluh " . self::Terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = " seratus" . self::Terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = self::Terbilang($angka / 100) . " ratus " . self::Terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = " seribu" . self::Terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = self::Terbilang($angka / 1000) . " ribu " . self::Terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = self::Terbilang($angka / 1000000) . " juta " . self::Terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = self::Terbilang($angka / 1000000000) . " miliar " . self::Terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $hasil = self::Terbilang($angka / 1000000000000) . " triliun " . self::Terbilang(fmod($angka, 1000000000000));
        }

        return trim($hasil);
    }

    public static function rp($val)
    {
        return "Rp " . number_format($val, 0, ",", ".");
    }

    public static function convertDateToIndo($date)
    {
        // Daftar nama bulan dan hari dalam bahasa Indonesia
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

        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        // Mengubah format tanggal ke dalam bahasa Indonesia
        $timestamp = strtotime($date);
        $day = date('l', $timestamp);  // Mendapatkan hari
        $month = date('F', $timestamp);  // Mendapatkan bulan
        $dateFormatted = date('d', $timestamp);  // Mendapatkan tanggal
        $year = date('Y', $timestamp);  // Mendapatkan tahun

        return [
            'hari' => $days[$day],
            'tanggal' => $dateFormatted,
            'bulan' => $months[$month],
            'tahun' => $year
        ];
    }

    public static function convertShortDateToIndo($date)
    {
        // Daftar nama bulan dan hari dalam bahasa Indonesia
        $months = [
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'Mei',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Agus',
            'September' => 'Sep',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Des'
        ];

        $days = [
            'Sunday' => 'Min',
            'Monday' => 'Sen',
            'Tuesday' => 'Sel',
            'Wednesday' => 'Rab',
            'Thursday' => 'Kam',
            'Friday' => 'Jum',
            'Saturday' => 'Sab'
        ];

        // Mengubah format tanggal ke dalam bahasa Indonesia
        $timestamp = strtotime($date);
        $day = date('l', $timestamp);  // Mendapatkan hari
        $month = date('F', $timestamp);  // Mendapatkan bulan
        $dateFormatted = date('d', $timestamp);  // Mendapatkan tanggal
        $year = date('Y', $timestamp);  // Mendapatkan tahun

        return [
            'hari' => $days[$day],
            'tanggal' => $dateFormatted,
            'bulan' => $months[$month],
            'tahun' => $year
        ];
    }

    public static function getIndoDate($date){
        $data = self::convertDateToIndo($date);
        return $data['tanggal'].' '.$data['bulan'].' '.$data['tahun'];
    }
}