<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Status;
use App\Models\Service;

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
        return back()->with('success', 'pedido feito com sucesso!');
    }
    public function list(){

        $userId = Auth::user()->id;
        $orders = Order::all()
        ->where('user_id', $userId);
        $statuses = Status::all();

        return view('order-list', compact('orders', 'statuses'));
    }
    public function received(){

        $userId = Auth::user()->id;

        $orders = Order::whereHas('service', function ($query) use ($userId) {
        $query->where('user_id', $userId);
        })->get();

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

        return back()->with('success', 'pedido feito com sucesso!');
    }
}
