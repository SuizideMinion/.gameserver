<?php

use App\Models\ServerData;
use App\Models\UserBuildings;
use App\Models\UserData;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api', 'checker']], function () {
    Route::get('/crown', function () {
        $ServerData = ServerData::get()->pluck('value', 'key');

        $UserBuildings = UserBuildings::where('value', 1)->where('time', '<', time())->get();
        foreach($UserBuildings AS $userBuilding )
        {
            UserBuildings::where('id', $userBuilding->id)->update([
                'value' => 2,
                'level' => $userBuilding->level + 1
            ]);
        }

        if ( (int)$ServerData['next.wirtschafts.Tick'] < time() )
        {
            echo 'TickTime';
            $userRess = [];
            $nextTick = (int)$ServerData['next.wirtschafts.Tick'];
            $ticks = $ServerData['wirtschafts.Tick'];

            $UserHeadQuaders = UserBuildings::where('build_id', 1)->where('value', 2)->with('getUserData')->get();
            for ($i = 1; $i <= 50; $i++) {
                foreach ($UserHeadQuaders as $User) {
                    $userData = $User->getUserData->pluck('value', 'key');

                    $userRessOld = json_decode($userData['ress']);

                    $userRess[$User->user_id] = [
                        'ress1' => ($userRess[$User->user_id]['ress1'] ?? $userRessOld->ress1) + $userData['ress1.proTick'],
                        'ress2' => ($userRess[$User->user_id]['ress2'] ?? $userRessOld->ress2) + $userData['ress2.proTick'],
                        'ress3' => ($userRess[$User->user_id]['ress3'] ?? $userRessOld->ress3) + $userData['ress3.proTick'],
                        'ress4' => ($userRess[$User->user_id]['ress4'] ?? $userRessOld->ress4) + $userData['ress4.proTick'],
                        'ress5' => ($userRess[$User->user_id]['ress5'] ?? $userRessOld->ress5) + $userData['ress5.proTick'],
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
        }
    });
});

