<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;

    protected $table = 'short_urls';


    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'clicks',
        'expires_at',
    ];


    protected $casts = [
        'expires_at' => 'datetime',
        'clicks'     => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
