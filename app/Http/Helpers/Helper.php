<?php

function ressCalc($id = 0)
{
    if ( $id == 0) $id = auth()->user()->id;

    // Planetare Energie
    // -> 1000 , 125 , 75 , 50
    // WHG 4000 , 500 , 200 , 100
    $ress1 = json_decode(session('ServerData')['Planetar.ress']->value)->ress1;
    $ress2 = json_decode(session('ServerData')['Planetar.ress']->value)->ress2;
    $ress3 = json_decode(session('ServerData')['Planetar.ress']->value)->ress3;
    $ress4 = json_decode(session('ServerData')['Planetar.ress']->value)->ress4;

    if( hasTech(1, 16) )
    {
        $ress1 = $ress1 * 4;
        $ress2 = $ress2 * 4;
        $ress3 = $ress3 * 3;
        $ress4 = $ress4 * 2;
    }
    if( hasTech(1, 5, 2) ) $ress1 = $ress1 * 4;
    if( hasTech(1, 6, 2) ) $ress2 = $ress2 * 4;
    if( hasTech(1, 7, 2) ) $ress3 = $ress3 * 3;
    if( hasTech(1, 8, 2) ) $ress4 = $ress4 * 2;

    \App\Models\UserData::where('user_id', $id)->where('key', 'ressProTick')->update([
        'value' => json_encode([
            'ress1' => $ress1,
            'ress2' => $ress2,
            'ress3' => $ress3,
            'ress4' => $ress4,
        ])
    ]);
    // M 2:1 | D 4:1 | I 6:1 | E 8:1
    // Fba+ 1:1 | 2:1 | 3:1 | 4:1
}

function hasTech($tech, $id, $level = 1, $user_id = 0)
{
    if ( $user_id == 0 ) {
        if ($tech == 1) return ((session('UserBuildings')[$id]->value ?? 0) == 2 and session('UserBuildings')[$id]->level >= $level ? true : false);
        if ($tech == 2) return ((session('UserResearchs')[$id]->value ?? 0) == 2 and session('UserBuildings')[$id]->level >= $level ? true : false);
    }
    if ($tech == 1)
        return ( \App\Models\UserBuildings::where('user_id', $user_id)->where('build_id', $id)->where('level', '>=', $level)->first() ? true:false);
    elseif ($tech == 2)
        return ( \App\Models\UserResearchs::where('user_id', $user_id)->where('research_id', $id)->where('level', '>=', $level)->first() ? true:false);
}

function uData($key)
{
    return (session('uData')[$key]->value ?? false);
}

function JSONuData($key)
{
    return json_decode(session('uData')[$key]->value ?? false);
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
