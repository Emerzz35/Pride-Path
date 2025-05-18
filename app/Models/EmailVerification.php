<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'verification_code',
        'user_data',
        'expires_at'
    ];

    protected $casts = [
        'user_data' => 'array',
        'expires_at' => 'datetime'
    ];

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
