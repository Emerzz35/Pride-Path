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
        'type' => 'required|in:user,service,order,comission,rating',
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
        'rating' => \App\Models\Rating::class,
    };

    $target = $modelClass::findOrFail($validated['id']);

    $report = $target->reports()->create([
        'user_id' => $user->id,
        'reason' => $validated['reason'],
    ]);

    return back()->with('success', 'Seu report foi enviado com sucesso!');
}
   public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar essa pagina.');
        }

        $reports = Report::with('user', 'reportable')
            ->when($request->filled('type'), function ($query) use ($request) {
                $modelClass = match($request->type) {
                    'user' => \App\Models\User::class,
                    'service' => \App\Models\Service::class,
                    'order' => \App\Models\Order::class,
                    'comission' => \App\Models\Comission::class,
                    default => null,
                };
                if ($modelClass) {
                    $query->where('reportable_type', $modelClass);
                }
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('reason', 'like', "%$search%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                    ->orWhereHas('reportable', function ($r) use ($search) {
                        $r->when($r->getModel() instanceof \App\Models\User, fn($q) => $q->where('name', 'like', "%$search%"))
                            ->when($r->getModel() instanceof \App\Models\Service, fn($q) => $q->where('name', 'like', "%$search%"))
                            ->when($r->getModel() instanceof \App\Models\Order, fn($q) => $q->where('name', 'like', "%$search%")->orWhere('description', 'like', "%$search%"))
                            ->when($r->getModel() instanceof \App\Models\Comission, fn($q) => $q->where('name', 'like', "%$search%")->orWhere('description', 'like', "%$search%"));
                    });
                });
            })
            ->orderByRaw("FIELD(reportable_type, 
                '".addslashes(\App\Models\User::class)."', 
                '".addslashes(\App\Models\Service::class)."', 
                '".addslashes(\App\Models\Order::class)."', 
                '".addslashes(\App\Models\Comission::class)."')")
            ->orderByDesc('created_at')
            ->get();

        return view('report-index', compact('reports'));
    }

    public function destroy($id)
{
    if (!Auth::user()->isAdmin()) {
        return redirect()->back()->with('error', 'Você não tem permissão para realizar essa ação.');
    }

    $report = Report::find($id);

    if (!$report) {
        return redirect()->back()->with('error', 'Report não encontrado.');
    }

    $report->delete();

    return redirect()->back()->with('success', 'Report deletado com sucesso.');
}




}
