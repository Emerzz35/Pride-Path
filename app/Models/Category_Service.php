<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service_Category extends Model
{
    protected $fillable = [
        'service_id',
        'category_id'
    ];
}
