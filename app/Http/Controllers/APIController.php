<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function saveUserData($token, $key, $value)
    {
        $uData = UserData::where('value', $token)->first();

        UserData::updateOrCreate(
            [
                'user_id' => $uData->user_id,
                'key' => $key
            ],
            [
                'value' => $value
            ]
        );
    }
}
