<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analaytic extends Model
{
    use HasFactory;

    protected $primaryKey = 'date';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'date',
        'api',
        'web',
        'total'
    ];

    protected $casts = [
        'date' => 'date'
    ];
}
