<?php

if (!function_exists('path')) {
    function path($path = '', $rel = true) {
        $base = dirname(dirname(__DIR__));
        $path = $base . DIRECTORY_SEPARATOR . $path;
        return preg_replace(
            "/[\/|\\]+([\.]{1,2}[\/|\\])?/",
            DIRECTORY_SEPARATOR,
            $path
        );
    }
}

if (!function_exists('rand_string')) {
    function rand_string($length = 30) {
        $range = array_merge(range('a', 'z'), range('A', 'Z'));

        $string = "";

        for ($ii = 0; $ii < $length; $ii++) {
            $string .= $range[rand(0, count($range))];
        }

        return $string;
    }
}
