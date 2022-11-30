<?php

use App\Models\ServerData;
use App\Models\UserBuildings;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware' => ['api', 'checker']], function () {
    Route::get('/crown', function () {
        $ServerData = ServerData::get()->pluck('value', 'key');

        $UserBuildings = UserBuildings::where('value', 1)->where('time', '<', time())->get();
        foreach($UserBuildings AS $userBuilding )
        {
            UserBuildings::update([
                'user_id' => auth()->user()->id,
                'build_id' => $userBuilding->id,
                'value' => 2,
                'level' => $userBuilding->level + 1
            ]);
//            UserBuildings::where('id', $userBuilding->id)->update(['value' => 2]);
//            UserBuildings::where('id', $userBuilding->id)->increment('level', 1);
        }
        ////////// IS TICK TIME ????
        ///
        if ( (int)$ServerData['next.wirtschafts.Tick'] < time() )
        {
            echo 'TickTime';
            $nextTick = (int)$ServerData['next.wirtschafts.Tick'];
            $ticks = $ServerData['wirtschafts.Tick'];

            for ($i = 1; $i <= 50; $i++) {

                $UserHeadQuaders = UserBuildings::where('build_id', 1)->where('value', 2)->with('getUserData')->get();
                foreach ($UserHeadQuaders as $User) {
                    $userData = $User->getUserData->pluck('value', 'key');
//                    dd($userData);
//                    $raw = "UPDATE `user_data` SET `value` = '2085001' WHERE `user_data`.`id` = 1; UPDATE `user_data` SET `value` = '5585001' WHERE `user_data`.`id` = 3; UPDATE `user_data` SET `value` = '19991' WHERE `user_data`.`id` = 5; UPDATE `user_data` SET `value` = '01' WHERE `user_data`.`id` = 7; UPDATE `user_data` SET `value` = '01' WHERE `user_data`.`id` = 9;";
//                    UserData::toSql();
//                    DB::select(DB::raw($raw));
//                    upsert([
//                        [
//                            'user_id' => $User->user_id,
//                            'key' => 'ress1',
                    $userRessOld = json_decode($userData['ress']);

                    $userRess = [
                        'ress1' => $userRessOld->ress1 + $userData['ress1.proTick'],
                        'ress2' => $userRessOld->ress2 + $userData['ress2.proTick'],
                        'ress3' => $userRessOld->ress3 + $userData['ress3.proTick'],
                        'ress4' => $userRessOld->ress4 + $userData['ress4.proTick'],
                        'ress5' => $userRessOld->ress5 + $userData['ress5.proTick'],
                    ];

                    UserData::where('user_id', $User->user_id)->where('key', 'ress')->update([
                        'value' => json_encode($userRess)
                    ]);
//                    UserData::where('user_id', $User->user_id)->where('key', 'ress1')->update(['value' => $userData['ress1.proTick'] + $userData['ress1']]);
//                    UserData::where('user_id', $User->user_id)->where('key', 'ress2')->update(['value' => $userData['ress2.proTick'] + $userData['ress2']]);
//                    UserData::where('user_id', $User->user_id)->where('key', 'ress3')->update(['value' => $userData['ress3.proTick'] + $userData['ress3']]);
//                    UserData::where('user_id', $User->user_id)->where('key', 'ress4')->update(['value' => $userData['ress4.proTick'] + $userData['ress4']]);
//                    UserData::where('user_id', $User->user_id)->where('key', 'ress5')->update(['value' => $userData['ress5.proTick'] + $userData['ress5']]);
//                            'value' =>
//                        ],
//                        [
//                            'user_id' => $User->user_id,
//                            'key' => 'ress2',
//                            'value' => $userData['ress2.proTick'] + $userData['ress2']
//                        ],
//                        [
//                            'user_id' => $User->user_id,
//                            'key' => 'ress3',
//                            'value' => $userData['ress3.proTick'] + $userData['ress3']
//                        ],
//                        [
//                            'user_id' => $User->user_id,
//                            'key' => 'ress4',
//                            'value' => $userData['ress4.proTick'] + $userData['ress4']
//                        ],
//                        [
//                            'user_id' => $User->user_id,
//                            'key' => 'ress5',
//                            'value' => $userData['ress5.proTick'] + $userData['ress5']
//                        ],
//                    ], ['value'], ['key', 'user_id']);
                }
                $nextTick = $nextTick + $ServerData['wirtschafts.Tick.Sekunden'];
                $ticks++;
                if ( $nextTick > time() )
                    break;
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

