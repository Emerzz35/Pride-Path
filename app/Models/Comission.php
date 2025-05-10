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

    public function reports() {
    return $this->morphMany(Report::class, 'reportable');
    }
    public function order(){
       return $this->belongsTo(Order::class);
    }
}
