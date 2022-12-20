<?php

namespace App\Http\Middleware;

use App\Models\Buildings;
use App\Models\Planet;
use App\Models\Researchs;
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
            ressCalc($userBuilding->user_id);
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
            if ( !isset($UsersData['race']) ) // TODO:: Race auswahl seite wenn Race Fehlt !!!
            {
                header('Location: /Race');
                exit;
            }

            if ( !isset($UsersData['x']) )
            {
                $korrds = Planet::where('user_id', NULL)->orderByRaw('RAND()')->first();
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'x',
                    'value' => $korrds['x']
                ]);
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'y',
                    'value' => $korrds['y']
                ]);
                Planet::where('id', $korrds->id)->update([
                    'user_id' => Auth::user()->id
                ]);
                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

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
                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

            if ( !isset($UsersData['kollektoren']) )
            {
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'kollektoren',
                    'value' => 0
                ]);
                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

            if ( !isset($UsersData['ressProTick']) )
            {
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ressProTick',
                    'value' => json_encode([
                        'ress1' => json_decode($ServerData['Planetar.ress']->value)->ress1,
                        'ress2' => json_decode($ServerData['Planetar.ress']->value)->ress2,
                        'ress3' => json_decode($ServerData['Planetar.ress']->value)->ress3,
                        'ress4' => json_decode($ServerData['Planetar.ress']->value)->ress4,
                        'ress5' => json_decode($ServerData['Planetar.ress']->value)->ress5,
                    ])
                ]);

                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

            if ( !isset($UsersData['ress.verteilung']) ) {
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'ress.verteilung',
                    'value' => json_encode([
                        'ress1' => 100,
                        'ress2' => 0,
                        'ress3' => 0,
                        'ress4' => 0,
                    ])
                ]);
            }

            if ( !isset($UsersData['token']) )
            {
                UserData::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'token',
                    'value' => md5(Auth::user()->id + 2555),
                ]);

                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
            }

            $UserBuildings = \App\Models\UserBuildings::where('user_id', Auth::user()->id)->get()->keyBy('build_id');
            $UserResearchs = \App\Models\UserResearchs::where('user_id', Auth::user()->id)->get()->keyBy('research_id');
            $Researchs = \App\Models\Researchs::with('getData')->get()->keyBy('id');
            $Buildings = \App\Models\Buildings::with('getData')->get()->keyBy('id');
            $Lang = Translations::where('lang', 'DE')->where('race', $UsersData['race']->value)->orWhere('race', 0)->get()->keyBy('key');

            session([
                'Lang' => $Lang,
                'UserBuildings' => $UserBuildings,
                'UserResearchs' => $UserResearchs,
                'uData' => $UsersData,
                'ServerData' => $ServerData,
                'Researchs' => $Researchs,
                'Buildings' => $Buildings
            ]);

//            dd($Researchs['3']);
//            dd(session('Researchs')[3]->getData->pluck('value','key'));
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
