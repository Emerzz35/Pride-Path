<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Rating;

class RatingController extends Controller
{
   public function store(Request $request, $serviceId)
{
    $validated = $request->validate([
        'rating' => 'required|integer|min:0|max:5',
        'comment' => 'nullable|max:500',
    ]);

    $user = Auth::user();
    $service = Service::findOrFail($serviceId);

    // Atualiza se já avaliou
    Rating::updateOrCreate(
        ['user_id' => $user->id, 'service_id' => $service->id],
        ['rating' => $validated['rating'], 'comment' => $validated['comment']]
    );

    return back()->with('success', 'Avaliação registrada com sucesso!');
}

}
