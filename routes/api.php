<?php

use App\Models\ServerData;
use App\Models\UserBuildings;
use App\Models\UserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['api', 'checker']], function () {
    Route::get('/crown', function () {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;

        $ServerData = ServerData::get()->pluck('value', 'key');

        $UserBuildings = UserBuildings::where('value', 1)->where('time', '<', time())->get();
        foreach($UserBuildings AS $userBuilding )
        {
            UserBuildings::where('id', $userBuilding->id)->update([
                'value' => 2,
                'level' => $userBuilding->level + 1
            ]);
            ressCalc($userBuilding->user_id);
        }

        if ( (int)$ServerData['next.wirtschafts.Tick'] < time() OR ($_GET['testTick'] ?? 0) == 1)
        {
            echo 'TickTime';
            $userRess = [];
            $nextTick = (int)$ServerData['next.wirtschafts.Tick'];
            $ticks = $ServerData['wirtschafts.Tick'];

            // Baue Kollektoren

            $userUnitsBuild = \App\Models\UserUnitsBuild::where('unit_id', '1')->orderBy('time')->with('getUserData')->get()->groupBy('user_id');

            foreach ( $userUnitsBuild AS $User)
            {
                $UserData = $User[0]->getUserData->keyBy('key');
//                dd($User[0], $UserData);
                if( $User[0]->quantity > 0)
                {
                    UserData::where('user_id', $User[0]->user_id)->where('key', 'kollektoren')->update([
                        'value' => $UserData['kollektoren']->value + 1
                    ]);
                    \App\Models\UserUnitsBuild::where('id', $User[0]->id)->update([
                        'quantity' => $User[0]->quantity - 1
                    ]);
                    ressCalc($User[0]->user_id);
                }
                if ($User[0]->quantity <= 1)
                {
                    \App\Models\UserUnitsBuild::where('id', $User[0]->id)->delete();
                }
            }

            // Baue EINHEITEN

            $userUnitsBuild = \App\Models\UserUnitsBuild::where('unit_id', '>', '1')->orderBy('time')->with('getUserData')->get();

            foreach ( $userUnitsBuild AS $User)
            {
//                $UserData = $User->getUserData->keyBy('key');
                $UserUnit = \App\Models\UserUnits::where('user_id', $User->id)->where('unit_id', $User->unit_id)->where('fleet', 0)->first();

                \App\Models\UserUnits::updateOrCreate(
                    [
                    'user_id' => $User->user_id,
                    'unit_id' => $User->unit_id,
                    'fleet' => 0
                    ],[
                    'value' => $User->quantity + ($UserUnit->value ?? 0)
                    ]
                );

                \App\Models\UserUnitsBuild::where('id', $User->id)->delete();
            }
//            dd($userUnitsBuild);

            // Baue Gebäude
            $UserHeadQuaders = UserBuildings::where('build_id', 1)->where('value', 2)->with('getUserData')->get();
            for ($i = 1; $i <= 50; $i++) {
                foreach ($UserHeadQuaders as $User) {
                    $userData = $User->getUserData->pluck('value', 'key');

                    if ( !isset($userData['ressProTick']) )
                    {
                        UserData::create([
                            'user_id' => $User->user_id,
                            'key' => 'ressProTick',
                            'value' => json_encode([
                                'ress1' => json_decode($ServerData['Planetar.ress'])->ress1,
                                'ress2' => json_decode($ServerData['Planetar.ress'])->ress2,
                                'ress3' => json_decode($ServerData['Planetar.ress'])->ress3,
                                'ress4' => json_decode($ServerData['Planetar.ress'])->ress4,
                                'ress5' => json_decode($ServerData['Planetar.ress'])->ress5,
                            ])
                        ]);
                        $userData = UserData::where('user_id', $User->user_id)->pluck('value', 'key');
                    }
                    $userRessOld = json_decode($userData['ress']);

                    $userRess[$User->user_id] = [
                        'ress1' => ($userRess[$User->user_id]['ress1'] ?? $userRessOld->ress1) + json_decode($userData['ressProTick'])->ress1,
                        'ress2' => ($userRess[$User->user_id]['ress2'] ?? $userRessOld->ress2) + json_decode($userData['ressProTick'])->ress2,
                        'ress3' => ($userRess[$User->user_id]['ress3'] ?? $userRessOld->ress3) + json_decode($userData['ressProTick'])->ress3,
                        'ress4' => ($userRess[$User->user_id]['ress4'] ?? $userRessOld->ress4) + json_decode($userData['ressProTick'])->ress4,
                        'ress5' => ($userRess[$User->user_id]['ress5'] ?? $userRessOld->ress5) + json_decode($userData['ressProTick'])->ress5,
                    ];

                }
                $nextTick = $nextTick + $ServerData['wirtschafts.Tick.Sekunden'];
                $ticks++;
                if ( $nextTick > time() )
                    break;
            }
            foreach ($userRess as $key => $value) {
                UserData::where('user_id', $key)->where('key', 'ress')->update([
                    'value' => json_encode($value)
                ]);
//                UserData::where('user_id', $key)->where('key', 'ress1')->update(['value' => $value['ress1']]);
//                UserData::where('user_id', $key)->where('key', 'ress2')->update(['value' => $value['ress2']]);
//                UserData::where('user_id', $key)->where('key', 'ress3')->update(['value' => $value['ress3']]);
//                UserData::where('user_id', $key)->where('key', 'ress4')->update(['value' => $value['ress4']]);
//                UserData::where('user_id', $key)->where('key', 'ress5')->update(['value' => $value['ress5']]);

            }
            ServerData::upsert([
                [
                    'id' => 1,
                    'key' => 'next.wirtschafts.Tick',
                    'value' => $nextTick
                ],
                [
                    'id' => 2,
                    'key' => 'wirtschafts.Tick',
                    'value' => $ticks
                ],
            ], 'value');
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 4);

            intoLogs('Wirtschafstick abgearbeitet in '.$total_time.' seconds.', link: url()->full());
        }
    });
    Route::get('uSettings/{token}/{key}/{value}', '\App\Http\Controllers\APIController@saveUserData');
    Route::get('message/{token}', '\App\Http\Controllers\MessageController@JSON');
});

