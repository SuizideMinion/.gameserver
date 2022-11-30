<?php

namespace App\Providers;

use App\Models\UserData;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('can', function ($value) {
            return ( UserData::where('user_id', auth()->user()->id)->where('key', 'can.' . $value)->first() OR UserData::where('user_id', auth()->user()->id)->where('key', 'can.isAdmin')->first() ? true:false );
        });

        Blade::directive('set', function($expression) {
            list($name, $val) = explode(',', $expression);
            return "<?php {$name} = {$val}; ?>";
        });
    }
}
