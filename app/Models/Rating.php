<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }
    
    public function reports() {
    return $this->morphMany(Report::class, 'reportable');
    }

    protected $fillable = [
        'comment',
        'rating',
        'service_id',
        'user_id'
    ];

}
