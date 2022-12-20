<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PlanetsCreateController extends Controller
{
    public function index()
    {
        set_time_limit(0);
        $arr = file( storage_path('csv/planetennamensliste.txt') );
        $position = array("left", "right", "top", "bottom", "center");
        $counter = 0;
        for($x=1; $x < 2000; $x++)
        {
            $korrds = getFreeCorrordinates();
            $size = rand(20,40);
            $Ressurce = rand(7,12);

            \App\Models\Planet::create([
              'name' => trim( $arr[array_rand($arr)] ),
              'y' => $korrds[0]['y'],
              'x' => $korrds[0]['x'],
              'posAtMap' => $position[rand(0,4)],
              'size' => $size,
              'img' => 's'.$Ressurce.'.png',
            ]);
            echo 'Planet => '.$korrds[0]['y'].':'.$korrds[0]['x'].' Erstellt<br>';
        }
    }
}
