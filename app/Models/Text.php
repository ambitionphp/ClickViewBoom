<?php

namespace App\Models;

use App\Traits\Snowflake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use Snowflake;
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'private_key',
        'user_id',
        'content',
        'password',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
