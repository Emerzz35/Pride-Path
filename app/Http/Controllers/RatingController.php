<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Rating;
use App\Models\Order;
use App\Models\Notification;

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

        $hasOrdered = Order::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->exists();

        if (! $hasOrdered) {
            return back()->with('error', 'Você só pode avaliar serviços que já comprou.');
        }


        // Atualiza se já avaliou
        Rating::updateOrCreate(
            ['user_id' => $user->id, 'service_id' => $service->id],
            ['rating' => $validated['rating'], 'comment' => $validated['comment']]
        );
        Notification::create([
            'user_id' => $service->user_id,
            'content' => "Seu serviço '{$service->name}' recebeu uma avaliação de {$validated['rating']} estrelas",
            'link' => "/servico/{$service->id}",
            'type' => Notification::TYPE_RATING
        ]);

        return back()->with('success', 'Avaliação registrada com sucesso!');
    }
    public function destroy($serviceId, $userId = null)
    {
        $authUser = Auth::user();
        if (!$authUser->isAdmin()) {
            if ($userId !== null && $authUser->id != $userId) {
                return back()->with('error', 'Você não tem permissão para deletar essa avaliação.');
            }

            $rating = Rating::where('user_id', $authUser->id)
                ->where('service_id', $serviceId)
                ->first();
        } else {

            $rating = Rating::where('service_id', $serviceId);

            if ($userId) {
                $rating = $rating->where('user_id', $userId);
            }

            $rating = $rating->first();
        }

        if (!$rating) {
            return back()->with('error', 'Avaliação não encontrada.');
        }

        $rating->delete();

        return back()->with('success', 'Avaliação removida com sucesso.');
    }



}
