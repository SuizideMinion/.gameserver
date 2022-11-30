<?php

function uData($key)
{
    return (session('uData')[$key]->value ?? false);
}

function uRess()
{
    return (json_decode(session('uData')['ress']->value) ?? false);
}

function Lang($key, $array = null)
{
    $text = (session('Lang')[$key]->value ?? session('Lang')['dummy']->value);

    if ( $array != null )
    {
        $text = str_replace(array_keys($array), array_values($array), $text);
    }

    return $text;
}

function timeconversion($sekunden): string
{
    $tag = floor($sekunden / (3600 * 24));
    $std = floor($sekunden / 3600 % 24);
    $min = floor($sekunden / 60 % 60);
    $sek = floor($sekunden % 60);
    return ($tag != 0 ? $tag . Lang('global.Day') .' ' : '') . ($std <= 9 ? '0' . $std : $std) . ':' . ($min <= 9 ? '0' . $min : $min) . ':' . ($sek <= 9 ? '0' . $sek : $sek);
}

function getImage($name, $path = null, $race = null): string
{
    return '/assets/img' . ($path != null ? '/' . $path : '') . '/' . $race . $name;
}

function number_shorten($number, $precision = 3, $divisors = null): string
{

// Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );
    }

// Loop through each $divisor and find the
// lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
// We found a match!
            break;
        }
    }

// We found our match, or there were no matches.
// Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}
