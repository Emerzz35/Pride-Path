<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comission extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order_id',
    ];
}
