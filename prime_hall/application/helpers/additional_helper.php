<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('show_price')) {

    function show_price($price, $sign = '')
    {

        $price = (float)$price;

        if ($price <= 0) {
            echo false;
            return false;
        }

        if (fmod($price, 1) == 0) {

            $price = intval($price);

        } else {

            $price = number_format($price, 2, ".", "");

        }

        if (!empty($sign)) {

            echo $sign . ' ' . $price;
        } else {

            echo $price;
        }

        return true;

    }

}

if (!function_exists('modify_number')) {

    function modify_number($number, $decimal = '2')
    {

        $number = str_ireplace(',', '', $number);

        $number = floatval($number);

        if (fmod($number, 1) == 0) {

            $number = intval($number);

        } else {

            $number = number_format($number, $decimal, ".", "");

        }

        return $number;

    }

}

if (!function_exists('show_date')) {

    function show_date($date, $bool = NULL)
    {

        if (empty($date)) {
            return false;
        }

        if ($date == '0000-00-00') {
            return false;
        }

        if($bool){

            return date('M-d-Y', strtotime($date));
        }
        echo date('M-d-Y', strtotime($date));

    }

}

if (!function_exists('sample_hash')) {

    function sample_hash($ip)
    {

        if (empty($ip)) {
            return false;
        }

        $hash = '';

        $str = sha1($ip);

        if (empty($str)) {
            return false;
        }

        $hash .= $str[1];
        $hash .= $str[7];
        $hash .= $str[10];
        $hash .= $str[3];
        $hash .= $str[5];

        $hash = sha1($hash);

        return $hash;

    }

}