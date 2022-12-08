<?php

function ressCalc($id = 0)
{
    if ( $id == 0) $id = auth()->user()->id;
    $userData = \App\Models\UserData::where('user_id', $id)->get()->keyBy('key');
    $ServerData = \App\Models\ServerData::get()->keyBy('key');

    $ress1 = json_decode($ServerData['Planetar.ress']->value)->ress1;
    $ress2 = json_decode($ServerData['Planetar.ress']->value)->ress2;
    $ress3 = json_decode($ServerData['Planetar.ress']->value)->ress3;
    $ress4 = json_decode($ServerData['Planetar.ress']->value)->ress4;

    if( hasTech(1, 16, 1, $id) )
    {
        $ress1 = $ress1 * 4;
        $ress2 = $ress2 * 4;
        $ress3 = $ress3 * 3;
        $ress4 = $ress4 * 2;
    }

    if($userData['kollektoren']->value)
    {
        $ressVerteilung = json_decode($userData['ress.verteilung']->value);
        $energy = $userData['kollektoren']->value * 100;

        if( hasTech(1, 5, 2, $id) ) $ress1 = $ress1 + intval($energy / 100 * $ressVerteilung->ress1);
        elseif ( hasTech(1, 5, 1, $id) ) $ress1 = $ress1 + intval($energy / 100 * $ressVerteilung->ress1 / 2);

        if( hasTech(1, 6, 2, $id) ) $ress2 = $ress2 + intval($energy / 100 * $ressVerteilung->ress2 / 2);
        elseif( hasTech(1, 6, 1, $id) ) $ress2 = $ress2 + intval($energy / 100 * $ressVerteilung->ress2 / 4);

        if( hasTech(1, 7, 2, $id) ) $ress3 = $ress3 + intval($energy / 100 * $ressVerteilung->ress3 / 3);
        elseif( hasTech(1, 7, 1, $id) ) $ress3 = $ress3 + intval($energy / 100 * $ressVerteilung->ress3 / 6);

        if( hasTech(1, 8, 2, $id) ) $ress4 = $ress4 + intval($energy / 100 * $ressVerteilung->ress4 / 4);
        elseif( hasTech(1, 8, 1, $id) ) $ress4 = $ress4 + intval($energy / 100 * $ressVerteilung->ress4 / 8);
    }

    if( hasTech(1, 5, 2, $id) ) $ress1 = $ress1 * 4;
    if( hasTech(1, 6, 2, $id) ) $ress2 = $ress2 * 4;
    if( hasTech(1, 7, 2, $id) ) $ress3 = $ress3 * 3;
    if( hasTech(1, 8, 2, $id) ) $ress4 = $ress4 * 2;

    \App\Models\UserData::where('user_id', $id)->where('key', 'ressProTick')->update([
        'value' => json_encode([
            'ress1' => $ress1,
            'ress2' => $ress2,
            'ress3' => $ress3,
            'ress4' => $ress4,
            'ress5' => 0,
        ])
    ]);
    // M 2:1 | D 4:1 | I 6:1 | E 8:1
    // Fba+ 1:1 | 2:1 | 3:1 | 4:1
}

function ressChanceDown($user_id, $ress1, $ress2, $ress3 = 0, $ress4 = 0, $ress5 = 0)
{
    $ress = json_decode(\App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->first()->value);
//    dd($ress);
    \App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->update([
        'value' => json_encode([
            'ress1' => number_format(( $ress->ress1 - $ress1 ),0,'',''),
            'ress2' => number_format(( $ress->ress2 - $ress2 ),0,'',''),
            'ress3' => number_format(( $ress->ress3 - $ress3 ),0,'',''),
            'ress4' => number_format(( $ress->ress4 - $ress4 ),0,'',''),
            'ress5' => number_format(( $ress->ress5 - $ress5 ),0,'',''),
        ])
    ]);
}

function ressChance($user_id, $ress1 = null, $ress2 = null, $ress3 = null, $ress4 = null, $ress5 = null)
{
    $ress = json_decode(\App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->first()->value);
//    dd($ress);
    \App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->update([
        'value' => json_encode([
            'ress1' => ( $ress1 != null ? number_format($ress1, 0 ,'', ''):$ress->ress1),
            'ress2' => ( $ress1 != null ? number_format($ress1, 0 ,'', ''):$ress->ress1),
            'ress3' => ( $ress1 != null ? number_format($ress1, 0 ,'', ''):$ress->ress1),
            'ress4' => ( $ress1 != null ? number_format($ress1, 0 ,'', ''):$ress->ress1),
            'ress5' => ( $ress1 != null ? number_format($ress1, 0 ,'', ''):$ress->ress1),
        ])
    ]);
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

function ServerData($key)
{
    return session('ServerData')[$key]->value ?? false;
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

function FormatTime($timestamp)
{
    // Get time difference and setup arrays
    $difference = time() - $timestamp;
    $periods = array("second", "minute", "hour", "day", "week", "month", "years");
    $lengths = array("60","60","24","7","4.35","12");

    // Past or present
    if ($difference >= 0)
    {
        $ending = "ago";
    }
    else
    {
        $difference = -$difference;
        $ending = "to go";
    }

    // Figure out difference by looping while less than array length
    // and difference is larger than lengths.
    $arr_len = count($lengths);
    for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++)
    {
        $difference /= $lengths[$j];
    }

    // Round up
    $difference = round($difference);

    // Make plural if needed
    if($difference != 1)
    {
        $periods[$j].= "s";
    }

    // Default format
    $text = "$difference $periods[$j] $ending";

    // over 24 hours
    if($j > 2)
    {
        // future date over a day formate with year
        if($ending == "to go")
        {
            if($j == 3 && $difference == 1)
            {
                $text = "Tomorrow at ". date("g:i a", $timestamp);
            }
            else
            {
                $text = date("F j, Y \a\\t g:i a", $timestamp);
            }
            return $text;
        }

        if($j == 3 && $difference == 1) // Yesterday
        {
            $text = "Yesterday at ". date("g:i a", $timestamp);
        }
        else if($j == 3) // Less than a week display -- Monday at 5:28pm
        {
            $text = date("l \a\\t g:i a", $timestamp);
        }
        else if($j < 6 && !($j == 5 && $difference == 12)) // Less than a year display -- June 25 at 5:23am
        {
            $text = date("F j \a\\t g:i a", $timestamp);
        }
        else // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
        {
            $text = date("F j, Y \a\\t g:i a", $timestamp);
        }
    }

    return $text;
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
