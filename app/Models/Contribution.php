<?php

namespace App\Models;

use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'anonymous',
        'name',
        'image_path',
        'email',
        'url',
        'stripe_token',
        'coffee',
        'hosting',
        'domain',
        'amount',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'anonymous' => 'boolean',
    ];

    public function getPieChartModelAttribute(){
        $enabled = 0;
        if($this->coffee)
            $enabled++;
        if($this->domain)
            $enabled++;
        if($this->hosting)
            $enabled++;

        $per = ( $this->amount / 100 ) / $enabled;

        $pieChartModel = (new PieChartModel())->withoutLegend();
        if($this->coffee)
            $pieChartModel = $pieChartModel->addSlice('Coffee', $per, '#fdba74');
        if($this->domain)
            $pieChartModel = $pieChartModel->addSlice('Domain', $per, '#c4b5fd');
        if($this->hosting)
            $pieChartModel = $pieChartModel->addSlice('Hosting', $per, '#93c5fd');

        return $pieChartModel;
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? Storage::disk(config('filesystems.default'))->url($this->image_path)
            : $this->defaultImageUrl();
    }

    protected function defaultImageUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return $segment[0] ?? '';
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    public function getAmountStringAttribute() {
        return '$'.( $this->amount / 100 );
    }
}
