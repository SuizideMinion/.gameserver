<?php

namespace App\Http\Middleware;

use App\Models\Translations;
use App\Models\UserData;
use App\Models\UserDatas;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Checker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        $UserTechnologies = \App\Models\UserTechnologies::where('status', 1)->where('time', '<', time())->get();
//        foreach($UserTechnologies AS $userTechnology )
//        {
//            \App\Models\UserTechnologies::where('id', $userTechnology->id)->update(['status' => 2]);
//        }
//
//        $ressTick = \App\Models\ServerData::where('key', 'next.wirtschafts.Tick')->first();
//        for($i = 1; $i <= 100; $i++)
//        {
//            if  ($ressTick->value <= time())
//            {
//                $Users = \App\Models\User::get();
//                foreach( $Users AS $User )
//                {
//                    if(!isset($User->userData()['ress1']))
//                    {
//                        $User->setUserData('ress1', '1000');
//                        $User->setUserData('ress1.proTick', '1000');
//                    }
//                    incrementUserData($User->id, 'ress1', $User->userData()['ress1.proTick']);
//                    if(!isset($User->userData()['ress2']))
//                    {
//                        $User->setUserData('ress2', '1000');
//                        $User->setUserData('ress2.proTick', '1000');
//                    }
//                    incrementUserData($User->id, 'ress2', $User->userData()['ress2.proTick']);
//                    if(!isset($User->userData()['ress3']))
//                    {
//                        $User->setUserData('ress3', '1000');
//                        $User->setUserData('ress3.proTick', '1000');
//                    }
//                    incrementUserData($User->id, 'ress3', $User->userData()['ress3.proTick']);
//                    if(!isset($User->userData()['ress4']))
//                    {
//                        $User->setUserData('ress4', '1000');
//                        $User->setUserData('ress4.proTick', '1000');
//                    }
//                    incrementUserData($User->id, 'ress4', $User->userData()['ress4.proTick']);
//                    if(!isset($User->userData()['ress5']))
//                    {
//                        $User->setUserData('ress5', '1000');
//                        $User->setUserData('ress5.proTick', '1000');
//                    }
//                    incrementUserData($User->id, 'ress5', $User->userData()['ress5.proTick']);
//                }
//
//                \App\Models\ServerData::where('id', $ressTick->id)->increment('value', getServerData('wirtschafts.Tick.Sekunden'));
//                \App\Models\ServerData::where('key', 'wirtschafts.Tick')->increment('value');
//                $ressTick->value = $ressTick->value + getServerData('wirtschafts.Tick.Sekunden');
//            } else break;
//        }

        if(Auth::user()){
            if ( !session()->has('Lang') )
            {
                $Lang = Translations::where('lang', 'DE')->get()->keyBy('key');

//            $UserTechnologies = \App\Models\UserTechnologies::where('user_id', Auth::user()->id)->get()->keyBy('tech_id');
                $UsersData = UserData::where('user_id', Auth::user()->id)->get()->keyBy('key');
                session([
//                'uTechnologies' => $UserTechnologies,
                    'Lang' => $Lang,
                    'uData' => $UsersData,
                ]);
            }

            UserData::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'key' => 'lastclick'
                ],
                [
                    'value' => time()
                ]
            );

        } else {
            return redirect('https://join.whinox.com/accounts');

        }
        return $next($request);
    }
}
