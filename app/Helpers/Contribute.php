<?php
namespace App\Helpers;

use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Boolean;

class Contribute {
    public static function days($type, $total) {
        $diffInDays = Carbon::parse(config('boom.birthday'))->diffInDays(now());
        if( ! $total ) return config('boom.contributions.'.$type.'.manual') - $diffInDays;
        $total = $total / 100;
        $value = $total / config('boom.contributions.'.$type.'.cost');
        return (int) ( config('boom.contributions.'.$type.'.manual') - $diffInDays ) + ( config('boom.contributions.'.$type.'.cost') * $value);
    }
}
