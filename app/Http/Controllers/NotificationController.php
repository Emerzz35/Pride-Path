<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Obter todas as notificações do usuário autenticado
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        return response()->json($notifications);
    }
    
    /**
     * Marcar uma notificação como lida
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Verificar se a notificação pertence ao usuário autenticado
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Marcar todas as notificações como lidas
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('read', false)
            ->update(['read' => true]);
            
        return response()->json(['success' => true]);
    }
    
    /**
     * Criar uma notificação (método auxiliar para testes)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'link' => 'nullable|string',
            'type' => 'required|string'
        ]);
        
        $notification = Notification::create($validated);
        
        return response()->json($notification, 201);
    }
}
