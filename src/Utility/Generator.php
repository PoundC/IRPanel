<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 6/23/17
 * Time: 1:37 AM
 */

namespace App\Utility;

class Generator
{
    public static function alphanumeric($count = 10) {

        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $count; $i++) {

            $string .= $characters[mt_rand(0, $max)];
        }

        return $string;
    }
}