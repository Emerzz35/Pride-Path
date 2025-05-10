<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|in:user,service,order,comission',
        'id' => 'required|integer',
        'reason' => 'required|min:5|max:500',
    ]);

    $user = Auth::user();

    // Determina o modelo correto
    $modelClass = match($validated['type']) {
        'user' => \App\Models\User::class,
        'service' => \App\Models\Service::class,
        'order' => \App\Models\Order::class,
        'comission' => \App\Models\Comission::class,
    };

    $target = $modelClass::findOrFail($validated['id']);

    $report = $target->reports()->create([
        'user_id' => $user->id,
        'reason' => $validated['reason'],
    ]);

    return back()->with('success', 'Seu report foi enviado com sucesso!');
}
    public function index()
    {

        if (!Auth::user()->isAdmin()) {
        return redirect()->back()->with('error', 'Você não tem permissão para acessar essa pagina.');
    }
        $reports = Report::with('user', 'reportable')->latest()->get();
        return view('report-index', compact('reports'));
    }


}
