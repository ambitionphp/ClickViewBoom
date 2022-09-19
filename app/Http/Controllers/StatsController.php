<?php

namespace App\Http\Controllers;

use App\Helpers\Stats;
use App\Charts\StatsChart;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function view() {
        SEOTools::setTitle('Stats');
        $stats = Stats::generate();
        $statsChart = new StatsChart;
        $statsChart->height(200);
        $statsChart->labels($stats['chart']['dates']);
        $statsChart->dataset('API Secrets', 'line', $stats['chart']['dataSets']['api']);
        $statsChart->dataset('Web Secrets', 'line', $stats['chart']['dataSets']['web']);
        $statsChart->dataset('Total Secrets', 'line', $stats['chart']['dataSets']['total']);

        $stats['chart'] = $statsChart;

        return view('stats', $stats);
    }
}
