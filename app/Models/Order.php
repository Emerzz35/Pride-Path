<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public function Status(): BelongsTo{
        return $this->belongsTo(Status::class,'statuses_id', 'id');
    }

    public function User(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function Service(): BelongsTo{
        return $this->belongsTo(Service::class);
    }
    public function Comission(){
        return $this->hasMany(Comission::class);
    }

    protected $fillable = [
        'name',
        'description',
        'service_id',
        'statuses_id',
        'user_id'
    ];
}
