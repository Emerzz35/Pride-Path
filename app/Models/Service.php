<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
   public function categories(){
       return $this->belongsToMany(Category::class);
    }

    public function ServiceImage(){
        return $this->hasMany(ServiceImage::class);
    }
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function reports() {
    return $this->morphMany(Report::class, 'reportable');
    }
    public function ratings() {
    return $this->hasMany(Rating::class);
    }

    public function averageRating() {
        return $this->ratings()->avg('rating');
    }



    protected $fillable = [
        'name',
        'description',
        'price',
        'activated',
        'user_id'
    ];
    
}
