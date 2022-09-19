<?php
namespace App\Helpers;

use App\Models\Analaytic;
use App\Models\User;
use Carbon\Carbon;

class Stats {
    public static $types = [
        'api',
        'web',
        'total'
    ];

    public static function generate() {
        $stats = Analaytic::get();
        $statsMapped = $stats->mapWithKeys(function ($item, $key) {
            $key = $item['date']->toDateString();
            unset($item['date']);
            return [$key => $item->toArray()];
        })->toArray();
        return [
            'users' => User::count(),
            'api' => $stats->sum('api'),
            'web' => $stats->sum('web'),
            'total' => $stats->sum('total'),
            'chart' => self::chartArray($statsMapped)
        ];
    }

    protected static function chartArray($stats) {
        $date = Carbon::parse(config('boom.birthday'));
        $return = [];
        while($date <= Carbon::now()) {
            $key = $date->toDateString();
            $return['dates'][] = $key;
            foreach(self::$types AS $type)
                $return['dataSets'][$type][] = $stats[$key][$type] ?? 0;

            $date = $date->addDay();
        }
        return $return;
    }
}
