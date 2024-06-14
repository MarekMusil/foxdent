<?php

namespace App\Helpers;

class CustomHelper
{
    public static function generateToken($type = 'alnum', $length = 40)
    {
        helper('text');
        $string = random_string($type, $length);
        return $string;
    }

    public static function generatePassword($type = 'alnum', $length = 10)
    {
        helper('text');
        $string = random_string($type, $length);
        return $string;
    }

    public static function formatPhoneNumber($phone_number)
    {
        $phone_number_format = preg_replace('/[^0-9]/', '', $phone_number);
        return $phone_number_format;
    }

    public static function generateUniqueName($type = 'alnum', $length = 40)
    {
        helper('text');
        $string = random_string($type, $length);
        return sha1($string.time());
    }

    public static function createSlug($text)
    {
        $text = strtolower($text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-zA-Z0-9_\s]/', '', $text);
        $text = str_replace(' ', '-', $text);

        return $text;
    }

    public static function arrayToXml($array, $xmlSettings = NULL, $withXmlSettings = false)
    {
        if ($withXmlSettings && !is_null($xmlSettings))
        {
            $xml = $xmlSettings;
        }
        else
        {
            $xml = '';
        }

        foreach ($array as $key => $value)
        {
            if ($key === '@attr')
            {
                continue;
            }

            if (strpos($key, '@array_') !== false)
            {
                $elementName = substr($key, strpos($key, '@array_') + strlen('@array_'));
                //print_r($value);
                foreach ($value as $arrayValue)
                {
                    $xml .= "<$elementName";
                    if (isset($arrayValue['@attr'])) {
                        foreach ($arrayValue['@attr'] as $attrKey => $attrValue) {
                            $xml .= " $attrKey=\"$attrValue\"";
                        }
                    }
                    $xml .= ">";
    
                    if (is_array($arrayValue)) {
                        if (isset($arrayValue['@attr'])) {
                            unset($arrayValue['@attr']);
                        }
                        if (isset($arrayValue['@val'])) {
                            $xml .= htmlspecialchars($arrayValue['@val']);
                        } else {
                            $xml .= self::arrayToXml($arrayValue);
                        }
                    } else {
                        $xml .= htmlspecialchars($arrayValue);
                    }
                    $xml .= "</$elementName>";
                }
            }
            else
            {
                $xml .= "<$key";
                // Přidání atributů, pokud jsou k dispozici
                if (isset($value['@attr'])) {
                    foreach ($value['@attr'] as $attrKey => $attrValue) {
                        $xml .= " $attrKey=\"$attrValue\"";
                    }
                }
                $xml .= ">";

                if (is_array($value)) {
                    if (isset($value['@attr'])) {
                        unset($value['@attr']);
                    }
                    if (isset($value['@val'])) {
                        $xml .= htmlspecialchars($value['@val']);
                    } else {
                        $xml .= self::arrayToXml($value);
                    }
                } else {
                    $xml .= htmlspecialchars($value);
                }
                $xml .= "</$key>";
            }
        }
        return $xml;
    }
}