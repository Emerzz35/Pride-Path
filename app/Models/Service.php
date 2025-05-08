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

    protected $fillable = [
        'name',
        'description',
        'price',
        'activated',
        'user_id'
    ];
    
}
