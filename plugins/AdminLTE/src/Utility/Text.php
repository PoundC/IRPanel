<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 10/10/17
 * Time: 3:02 PM
 */

namespace AdminLTE\Utility;

class Text {

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }

    public static function trimTo($subject, $count)
    {
        if(strlen($subject) >= $count) {

            return substr($subject, 0, $count - 1);
        }
        else {

            return $subject;
        }
    }
}
