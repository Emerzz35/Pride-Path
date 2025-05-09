<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Status;

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
}
