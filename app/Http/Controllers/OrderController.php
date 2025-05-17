<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Status;
use App\Models\Service;
use App\Models\Notification;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|max:200',
            'description' => 'required|min:14|max:500',
        ]);
        $userId = Auth::user()->id;
        $status = Status::where('name', 'em analise')->first();
        $service = Service::find($request->service_id);

        if($userId == $service->user_id){
        return back()->with('error', 'Você não pode comprar seu proprio serviço');
        }
        
        $Order = Order::create([
            'name' => $request->name,
            'description' => $request->description,
            'service_id' => $request->service_id,
            'user_id' => $userId,
            'statuses_id' => $status->id,
        ]);

        Notification::create([
            'user_id' => $service->user_id,
            'content' => "Novo pedido para seu serviço '{$service->name}'",
            'link' => "/minhas-entregas?status={$status->id}",
            'type' => Notification::TYPE_ORDER
        ]);

        return back()->with('success', 'pedido feito com sucesso!');
    }
    public function list(Request $request) {
        $userId = Auth::user()->id;
    
        $orders = Order::select('orders.*')
            ->join('statuses', 'orders.statuses_id', '=', 'statuses.id')
            ->where('orders.user_id', $userId)
            ->when($request->filled('search'), function ($query) use ($request) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('orders.name', 'like', "%$searchTerm%")
                      ->orWhere('orders.description', 'like', "%$searchTerm%")
                      ->orWhereHas('service', function ($serviceQuery) use ($searchTerm) {
                          $serviceQuery->where('name', 'like', "%$searchTerm%");
                      });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('orders.statuses_id', $request->status);
            })
            ->orderByRaw("CASE statuses.name
                WHEN 'em produção' THEN 1
                WHEN 'em analise' THEN 2
                WHEN 'entregue' THEN 3
                WHEN 'negado' THEN 4
                ELSE 5 END")
            ->orderBy('orders.created_at', 'desc')
            ->get();
    
        $statuses = Status::all();
    
        return view('order-list', compact('orders', 'statuses'));
    }
    
    
    public function received(Request $request) {
        $userId = Auth::user()->id;
    
        $orders = Order::select('orders.*')
            ->join('statuses', 'orders.statuses_id', '=', 'statuses.id')
            ->whereHas('service', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('orders.name', 'like', "%$searchTerm%")
                      ->orWhere('orders.description', 'like', "%$searchTerm%")
                      ->orWhereHas('service', function ($serviceQuery) use ($searchTerm) {
                          $serviceQuery->where('name', 'like', "%$searchTerm%");
                      });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('orders.statuses_id', $request->status);
            })
            ->orderByRaw("CASE statuses.name
                WHEN 'em analise' THEN 1
                WHEN 'em produção' THEN 2
                WHEN 'entregue' THEN 3
                WHEN 'negado' THEN 4
                ELSE 5 END")
            ->orderBy('orders.created_at', 'desc')
            ->get();
    
        $statuses = Status::all();
    
        return view('order-list', compact('orders', 'statuses'));
    }
    
    
    public function accept(Request $request){

        $status = Status::where('name', 'em produção')->first(); 
        $orderId = $request->order_id;
        $order = Order::find($orderId);

        $order->update([
            'statuses_id' => $status->id,
        ]);        
        return redirect()->back()->with('success', 'Pedido aceito com sucesso!');
    }
    public function deny(Request $request){

        $status = Status::where('name', 'negado')->first(); 
        $orderId = $request->order_id;
        $order = Order::find($orderId);

        $order->update([
            'statuses_id' => $status->id,
        ]);        
        return redirect()->back()->with('success', 'Pedido negado com sucesso!');
    }
    public function comission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|max:200',
            'description' => 'required|min:14|max:500',
        ]);
        $userId = Auth::user()->id;
        $status = Status::where('name', 'entregue')->first();
        $orderId = $request->order_id;
        $order = Order::find($orderId);

        
        $Order = Comission::create([
            'name' => $request->name,
            'description' => $request->description,
            'order_id' => $request->order_id,
        ]);

        $order->update([
            'statuses_id' => $status->id,
        ]);

         Notification::create([
            'user_id' => $order->user_id,
            'content' => "Seu pedido '{$order->name}' foi entregue",
            'link' => "/meus-pedidos?status={$status->id}",
            'type' => Notification::TYPE_COMISSION
        ]);

        return back()->with('success', 'pedido entregue com sucesso!');
    }
}
