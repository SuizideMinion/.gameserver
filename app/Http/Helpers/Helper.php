<?php

use App\Models\ResearchsData;

function timerHTML($id, $time)
{
    return "
<div id='timer". $id ."'></div>
<script>
    var ". $id ." = new Date();
	". $id ." = (Date.parse(". $id .") / 1000 + ". $time .");
       function make". $id ."Timer() {
        var now = new Date();
        now = (Date.parse(now) / 1000);

        var timeLeft = ". $id ." - now;

        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

        if (hours < '10') { hours = '0' + hours; }
        if (minutes < '10') { minutes = '0' + minutes; }
        if (seconds < '10') { seconds = '0' + seconds; }
        if (timeLeft <= 0)
        {
            $('#timer" . $id . "').html('". Lang('timer.finish') ."');
            clearInterval(". $id ."Timer);
        }
        else
            $('#timer". $id ."').html(days + ':'+
                   hours + ':'+
                   minutes + ':' +
                   seconds);
	}
	let ". $id ."Timer = setInterval(function() { make". $id ."Timer(); }, 1000);
</script>

    ";
}


function hasBuildNeed($id, $art = 2)
{
//    $getData = ResearchsData::where('research_id', $id)->where('key', 'build_need')->first();
    if( $art == 2 ) $getData = session('Researchs')[$id]->getData->pluck('value', 'key');
    else $getData = session('Buildings')[$id]->getData->pluck('value', 'key');

    $array = [];

    if ( isset($getData['build_need']) OR isset($getData['1.build_need']) ) {
        $values = json_decode(($getData['build_need'] ?? $getData['1.build_need'] ));

        foreach ($values as $value) {
            if ($value[0]->art == 1) {
//                $getDataBuild = \App\Models\BuildingsData::where('build_id', $value[0]->id)->get()->pluck('value', 'key');
                $getDataBuild = session('Buildings')[$value[0]->id]->getData->pluck('value', 'key');
                $array[$value[0]->art . '_' . $value[0]->id] = [
                    'name' => Lang('Building.name.' . $value[0]->id),
                    'desc' => Lang('Building.desc.' . $value[0]->id),
                    'id' => $value[0]->id,
                    'level' => $value[0]->level,
                    'art' => $value[0]->art,
                    'build_need' => ($getDataBuild[$value[0]->level . '.build_need'] ?? ''),
                    'build_time' => ($getDataBuild[$value[0]->level . '.tech_build_time'] ?? ''),
                    'ress1' => ($getDataBuild[$value[0]->level . '.ress1'] ?? '0'),
                    'ress2' => ($getDataBuild[$value[0]->level . '.ress2'] ?? '0'),
                    'ress3' => ($getDataBuild[$value[0]->level . '.ress3'] ?? '0'),
                    'ress4' => ($getDataBuild[$value[0]->level . '.ress4'] ?? '0'),
                    'ress5' => ($getDataBuild[$value[0]->level . '.ress5'] ?? '0'),
                    'image' => 'technologies/' . ($getDataBuild['1.image'] ?? '0'),
//                    'hasBuilds' => hasBuildNeed($value[0]->id)
                ];
            }
            if ($value[0]->art == 2) {
//                $getDataResearch = \App\Models\ResearchsData::where('research_id', $value[0]->id)->get()->pluck('value', 'key');
                $getDataResearch = session('Researchs')[$value[0]->id]->getData->pluck('value', 'key');
//                dd($getDataResearch);
                $array[$value[0]->art . '_' . $value[0]->id] = [
                    'name' => Lang('Research.name.' . $value[0]->id),
                    'desc' => Lang('Research.desc.' . $value[0]->id),
                    'id' => $value[0]->id,
                    'level' => $value[0]->level,
                    'art' => $value[0]->art,
                    'build_need' => ($getDataResearch['build_need'] ?? ''),
                    'group' => ($getDataResearch['group'] ?? ''),
                    'build_time' => ($getDataResearch['tech_build_time'] ?? ''),
                    'ress1' => ($getDataResearch['ress1'] ?? '0'),
                    'ress2' => ($getDataResearch['ress2'] ?? '0'),
                    'ress3' => ($getDataResearch['ress3'] ?? '0'),
                    'ress4' => ($getDataResearch['ress4'] ?? '0'),
                    'ress5' => ($getDataResearch['ress5'] ?? '0'),
                    'image' => 'research/' . ($getDataResearch['image'] ?? '0'),
//                    'hasBuilds' => hasBuildNeed($value[0]->id)
                ];
            }
        }
    }
    return $array;
}

function ressCalc($id = 0)
{
    if ($id == 0) $id = auth()->user()->id;
    $userData = \App\Models\UserData::where('user_id', $id)->get()->keyBy('key');
    $ServerData = \App\Models\ServerData::get()->keyBy('key');

    $ress1 = json_decode($ServerData['Planetar.ress']->value)->ress1;
    $ress2 = json_decode($ServerData['Planetar.ress']->value)->ress2;
    $ress3 = json_decode($ServerData['Planetar.ress']->value)->ress3;
    $ress4 = json_decode($ServerData['Planetar.ress']->value)->ress4;

    if (hasTech(1, 16, 1, $id)) {
        $ress1 = $ress1 * 4;
        $ress2 = $ress2 * 4;
        $ress3 = $ress3 * 3;
        $ress4 = $ress4 * 2;
    }

    if ($userData['kollektoren']->value) {
        $ressVerteilung = json_decode($userData['ress.verteilung']->value);
        $energy = $userData['kollektoren']->value * 100;

        if (hasTech(1, 5, 2, $id)) $ress1 = $ress1 + intval($energy / 100 * $ressVerteilung->ress1);
        elseif (hasTech(1, 5, 1, $id)) $ress1 = $ress1 + intval($energy / 100 * $ressVerteilung->ress1 / 2);

        if (hasTech(1, 6, 2, $id)) $ress2 = $ress2 + intval($energy / 100 * $ressVerteilung->ress2 / 2);
        elseif (hasTech(1, 6, 1, $id)) $ress2 = $ress2 + intval($energy / 100 * $ressVerteilung->ress2 / 4);

        if (hasTech(1, 7, 2, $id)) $ress3 = $ress3 + intval($energy / 100 * $ressVerteilung->ress3 / 3);
        elseif (hasTech(1, 7, 1, $id)) $ress3 = $ress3 + intval($energy / 100 * $ressVerteilung->ress3 / 6);

        if (hasTech(1, 8, 2, $id)) $ress4 = $ress4 + intval($energy / 100 * $ressVerteilung->ress4 / 4);
        elseif (hasTech(1, 8, 1, $id)) $ress4 = $ress4 + intval($energy / 100 * $ressVerteilung->ress4 / 8);
    }

//    if( hasTech(1, 5, 2, $id) ) $ress1 = $ress1 * 4;
//    if( hasTech(1, 6, 2, $id) ) $ress2 = $ress2 * 4;
//    if( hasTech(1, 7, 2, $id) ) $ress3 = $ress3 * 3;
//    if( hasTech(1, 8, 2, $id) ) $ress4 = $ress4 * 2;

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
    return '';
}


function ressChanceDown($user_id, $ress1, $ress2, $ress3 = 0, $ress4 = 0, $ress5 = 0)
{
    $ress = json_decode(\App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->first()->value);
//    dd($ress);
    \App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->update([
        'value' => json_encode([
            'ress1' => number_format(($ress->ress1 - $ress1), 0, '', ''),
            'ress2' => number_format(($ress->ress2 - $ress2), 0, '', ''),
            'ress3' => number_format(($ress->ress3 - $ress3), 0, '', ''),
            'ress4' => number_format(($ress->ress4 - $ress4), 0, '', ''),
            'ress5' => number_format(($ress->ress5 - $ress5), 0, '', ''),
        ])
    ]);
}

function ressChance($user_id, $ress1 = null, $ress2 = null, $ress3 = null, $ress4 = null, $ress5 = null)
{
    $ress = json_decode(\App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->first()->value);
//    dd($ress);
    \App\Models\UserData::where('user_id', $user_id)->where('key', 'ress')->update([
        'value' => json_encode([
            'ress1' => ($ress1 != null ? number_format($ress1, 0, '', '') : $ress->ress1),
            'ress2' => ($ress2 != null ? number_format($ress2, 0, '', '') : $ress->ress2),
            'ress3' => ($ress3 != null ? number_format($ress3, 0, '', '') : $ress->ress3),
            'ress4' => ($ress4 != null ? number_format($ress4, 0, '', '') : $ress->ress4),
            'ress5' => ($ress5 != null ? number_format($ress5, 0, '', '') : $ress->ress5),
        ])
    ]);
}

function canTech($tech, $id, $level = 1, $user_id = 0, $ress = 1)
{
    $c = 1;
    if ($tech == 1) {
        $select = 'UserBuildings';
        $getData = session('Buildings')[$id]->getData->pluck('value', 'key');
        if ((session($select)[$id]->value ?? 0) == 2) {
            if (($getData['1.max_level'] ?? '1') == session($select)[$id]->level) return false;
            $c = session($select)[$id]->level + 1;
        }
    }
    if ($tech == 2) {
        $select = 'UserResearchs';
        $getData = session('Researchs')[$id]->getData->pluck('value', 'key');
        if ((session($select)[$id]->value ?? 0) == 1) {
            return false;
        }
    }

    if (isset($getData[($select == 'UserBuildings' ? $c . '.' : '') . 'build_need'])) {
        $keys = json_decode($getData[($select == 'UserBuildings' ? $c . '.' : '') . 'build_need']);

        foreach ($keys as $array) {
            $id = $array[0]->id;
            if ($array[0]->art == 1) {
                // Gebäude
                if (isset(session('UserBuildings')[$id])) {
                    if (session('UserBuildings')[$id]->value == 2) {
                        if (session('UserBuildings')[$id]->level < $array[0]->level) return false;
                    }
                } else return false;

            } elseif ($array[0]->art == 2) {
                // Research
                if (isset(session('UserResearchs')[$id])) {
                    if (session('UserResearchs')[$id]->value != 2) {
                        return false;
                        //
                    }
                } else return false;
            }
        }
    }
    if ( $ress = 1 ) {
        if ((int)uRess()->ress1 < (int)$getData[($select == 'UserBuildings' ? $c . '.' : '') . 'ress1'])
            return false;
        if ((int)uRess()->ress2 < (int)$getData[($select == 'UserBuildings' ? $c . '.' : '') . 'ress2'])
            return false;
        if ((int)uRess()->ress3 < (int)$getData[($select == 'UserBuildings' ? $c . '.' : '') . 'ress3'])
            return false;
        if ((int)uRess()->ress4 < (int)$getData[($select == 'UserBuildings' ? $c . '.' : '') . 'ress4'])
            return false;
        if ((int)uRess()->ress5 < (int)$getData[($select == 'UserBuildings' ? $c . '.' : '') . 'ress5'])
            return false;
    }

    return true;
//        return ['notDisplay' => true, 'value' => 'lol10'];
}

function hasTech($tech, $id, $level = 1, $user_id = 0)
{
    if ($user_id == 0) {
        if ($tech == 1) return ((session('UserBuildings')[$id]->value ?? 0) == 2 and session('UserBuildings')[$id]->level >= $level ? true : false);
        if ($tech == 2) return ((session('UserResearchs')[$id]->value ?? 0) == 2 and session('UserResearchs')[$id]->level >= $level ? true : false);
    }
    if ($tech == 1)
        return (\App\Models\UserBuildings::where('user_id', $user_id)->where('build_id', $id)->where('level', '>=', $level)->first() ? true : false);
    elseif ($tech == 2)
        return (\App\Models\UserResearchs::where('user_id', $user_id)->where('research_id', $id)->where('level', '>=', $level)->first() ? true : false);
}

function getFreeCorrordinates()
{
    for($x=1; $x < 3500; $x++)
    {
        $X = rand(1,256);
        $Y = rand(1,256);
        if(empty(\App\Models\Planet::where('x', $X)->where('y', $Y)->first()))
        {
//            if(empty(\App\Models\User::where('posXmap', $X)->where('posYmap', $Y)->first()))
//            {
                return array(['x' => $X, 'y' => $Y]);
//            }
        }
    }
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

function Lang($key, $array = null, $plural = null)
{
    if ($plural == null or $plural == 1) $text = (session('Lang')[$key]->value ?? session('Lang')['dummy']->value .'('. $key .')');
    else $text = (session('Lang')[$key]->plural ?? session('Lang')['dummy']->value .'('. $key .')');

    if ($array != null) {
        $text = str_replace(array_keys($array), array_values($array), $text);
    }

    return $text;
}

function randPlanetName() {
    $handle = @fopen(storage_path() . '/csv/planetennamensliste.txt', 'r');
//    dd($handle);
    if ($handle) {
        $random_line = null;
        $line = null;
        $count = 0;

//        dd($handle);
        while (($line = fgets($handle, 4096)) !== false) {
            $count++;
            // P(1/$count) probability of picking current line as random line
            if(rand() % $count == 0) {
                $random_line = $line;
            }
        }
        if (!feof($handle)) {
            fclose($handle);
            return  "Error: unexpected fgets() fail\n";
        } else {
            fclose($handle);
        }
        return str_replace("\r\n",'',  $random_line);
    }
}

function timeconversion($sekunden): string
{
    $tag = floor($sekunden / (3600 * 24));
    $std = floor($sekunden / 3600 % 24);
    $min = floor($sekunden / 60 % 60);
    $sek = floor($sekunden % 60);
    return ($tag != 0 ? $tag . Lang('global.Day') . ' ' : '') . ($std <= 9 ? '0' . $std : $std) . ':' . ($min <= 9 ? '0' . $min : $min) . ':' . ($sek <= 9 ? '0' . $sek : $sek);
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
    $lengths = array("60", "60", "24", "7", "4.35", "12");

    // Past or present
    if ($difference >= 0) {
        $ending = Lang('global.ago');
    } else {
        $difference = -$difference;
        $ending = "to go";
    }

    // Figure out difference by looping while less than array length
    // and difference is larger than lengths.
    $arr_len = count($lengths);
    for ($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++) {
        $difference /= $lengths[$j];
    }

    // Round up
    $difference = round($difference);

    // Make plural if needed
    if ($difference != 1) {
        $periods[$j] = Lang('global.' . $periods[$j], plural: 'yes');
    } else $periods[$j] = Lang('global.' . $periods[$j]);

    // Default format
    $text = "$difference $periods[$j] $ending";

    // over 24 hours
    if ($j > 2) {
        // future date over a day formate with year
        if ($ending == "to go") {
            if ($j == 3 && $difference == 1) {
                $text = "Tomorrow at " . date("g:i a", $timestamp);
            } else {
                $text = date("F j, Y \a\\t g:i a", $timestamp);
            }
            return $text;
        }

        if ($j == 3 && $difference == 1) // Yesterday
        {
            $text = "Yesterday at " . date("g:i a", $timestamp);
        } else if ($j == 3) // Less than a week display -- Monday at 5:28pm
        {
            $text = date("l \a\\t g:i a", $timestamp);
        } else if ($j < 6 && !($j == 5 && $difference == 12)) // Less than a year display -- June 25 at 5:23am
        {
            $text = date("F j \a\\t g:i a", $timestamp);
        } else // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
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

function intoLogs($text, $user_id = 0, $link = 0, $previous = 0, $post = 0)
{
    \App\Models\Logs::create([
        'user_id' => $user_id,
        'text' => $text,
        'link' => $link,
        'previous' => $previous,
        'post' => $post,
        'time' => time()
    ]);
}

