<?php

namespace App\Http\Middleware;

use App\Models\ServerData;
use App\Models\Translations;
use App\Models\UserBuildings;
use App\Models\UserData;
use App\Models\UserDatas;
use App\Models\UserResearchs;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Checker
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $UserBuildings = UserBuildings::where('value', 1)->where('time', '<', time())->get();
        foreach($UserBuildings AS $userBuilding )
        {
            UserBuildings::where('id', $userBuilding->id)->update([
                'value' => 2,
                'level' => $userBuilding->level + 1
            ]);
        }
        $UserResearchs = UserResearchs::where('value', 1)->where('time', '<', time())->get();
        foreach($UserResearchs AS $UserResearch )
        {
            UserResearchs::where('id', $UserResearch->id)->update([
                'value' => 2,
                'level' => 1
            ]);
        }

        if (Auth::user()) {
            $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            $ServerData = ServerData::get()->keyBy('key');

            if ( !isset($UsersData['ress']) )
            {
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress',
                    'value' => json_encode([
                        'ress1' => $ServerData['Startress.ress1']->value,
                        'ress2' => $ServerData['Startress.ress2']->value,
                        'ress3' => $ServerData['Startress.ress3']->value,
                        'ress4' => $ServerData['Startress.ress4']->value,
                        'ress5' => $ServerData['Startress.ress5']->value,
                    ])
                ]);
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress1.proTick',
                    'value' => $ServerData['Planetar.ress1']->value,
                ]);
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress2.proTick',
                    'value' => $ServerData['Planetar.ress2']->value,
                ]);
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress3.proTick',
                    'value' => $ServerData['Planetar.ress3']->value,
                ]);
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress4.proTick',
                    'value' => $ServerData['Planetar.ress4']->value,
                ]);
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress5.proTick',
                    'value' => $ServerData['Planetar.ress5']->value,
                ]);

                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

            if ( !isset($UsersData['race']) ) // TODO:: Race auswahl seite wenn Race Fehlt !!!
            {
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'race',
                    'value' => 1,
                ]);

                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

            $UserBuildings = \App\Models\UserBuildings::where('user_id', Auth::user()->id)->get()->keyBy('build_id');
            $UserResearchs = \App\Models\UserResearchs::where('user_id', Auth::user()->id)->get()->keyBy('research_id');
            $Lang = Translations::where('lang', 'DE')->where('race', $UsersData['race']->value)->orWhere('race', 0)->get()->keyBy('key');


            session([
                'Lang' => $Lang,
                'UserBuildings' => $UserBuildings,
                'UserResearch' => $UserResearchs,
                'uData' => $UsersData,
                'ServerData' => $ServerData
            ]);
            UserData::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'key' => 'lastclick'
                ],
                [
                    'value' => time()
                ]
            );

        }
        return $next($request);
    }
}
