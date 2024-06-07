<?php

namespace App\Helpers;

class LogHelper
{
    /* public static function generateToken($type = 'alnum', $length = 40)
    {
        helper('text');
        $string = random_string($type, $length);
        return $string;
    } */

    public static function putAppLog($data)
    {
        if (is_array($data) === TRUE)
        {
            file_put_contents(WRITEPATH . '/debug_logs/file_' . rand(0, 99999) . '.txt', print_r($data, TRUE));
            return TRUE;
        }

        $write = file_put_contents(WRITEPATH . '/debug_logs/file_' . rand(0, 99999) . '.txt', $data);

        return TRUE;
    }

}