<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'link',
        'read',
        'type'
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // Marcar notificação como lida
    public function markAsRead()
    {
        $this->read = true;
        $this->save();
    }
    
    // Tipos de notificação
    const TYPE_ORDER = 'order';
    const TYPE_RATING = 'rating';
    const TYPE_COMISSION = 'comission';
}
