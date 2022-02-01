<?php

namespace App\Models;

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
