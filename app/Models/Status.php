<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function Order(){
        return $this->hasMany(Order::class);
    }
}
