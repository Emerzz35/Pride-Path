<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceImage;
use App\Models\Rating;

class ServiceController extends Controller
{
    public function create(Request $request)
    {
        $categories = Category::all();
        return view('service-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|max:200',
            'description' => 'required|min:14|max:500',
            'price' => [
                'required',
                function ($attribute, $value, $fail) {
                    $cleaned = str_replace(['R$', '.', ','], ['', '', '.'], $value);
                    if (!is_numeric($cleaned) || floatval($cleaned) <= 0) {
                        $fail('O campo preço deve ser um número válido maior que zero.');}}],
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',            
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cleanPrice = str_replace(['R$', '.', ','], ['', '', '.'], $request->price);
        $priceValue = floatval($cleanPrice);
        $userId = Auth::user()->id;
        
        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $priceValue,
            'user_id' => $userId,
            'activated' => true,
        ]);

        $service->categories()->attach($request->categories);
        if ($request->hasFile('images')) {
            $order = 1;
            foreach ($request->file('images') as $imageFile) {
                if ($imageFile->isValid()) {
                    $extension = $imageFile->extension();
                    $imageName = md5($imageFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $imageFile->move(public_path('img/services'), $imageName);
    
                    ServiceImage::create([
                        'service_id' => $service->id,
                        'url' => 'img/services/' . $imageName, // caminho salvo no banco
                        'order' => $order,
                    ]);
    
                    $order++; // incrementa ordem das imagens
                }
            }
        }

        return redirect()->route('service-show', $service->id);

    }

    public function show(Service $Service){
        $Services = Service::all();
        $categories = Category::all();
        $serviceCategories = $Service->categories->pluck('id')->toArray();

        $ratings = Rating::with('user')
        ->where('service_id', $Service->id)
        ->latest()
        ->get();

        $user = Auth::user();

        $ratingExists = $user
            ? Rating::where('user_id', $user->id)->where('service_id', $Service->id)->exists()
            : false;
        
    // Verificar se o usuário já fez um pedido deste serviço
    $hasMadeOrder = false;
    if ($user) {
        $hasMadeOrder = \App\Models\Order::where('user_id', $user->id)
            ->where('service_id', $Service->id)
            ->exists();
    }

    return view('service-show')
        ->with('Service', $Service)
        ->with('categories', $categories)
        ->with('serviceCategories', $serviceCategories)
        ->with('ratings', $ratings)
        ->with('ratingExists', $ratingExists)
        ->with('hasMadeOrder', $hasMadeOrder);
}

    public function index(Request $request) {
        $query = Service::with(['ServiceImage', 'categories', 'ratings'])->where('activated', 1);

        // Filtro por categoria
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filtro por pesquisa
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('categories', function ($catQuery) use ($searchTerm) {
                      $catQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Ordenação
        if ($request->filled('orderBy')) {
            switch ($request->orderBy) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating_desc':
                    $query->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating');
                    break;
                case 'rating_asc':
                    $query->withAvg('ratings', 'rating')->orderBy('ratings_avg_rating', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Ordenação padrão: mais recentes primeiro
            $query->orderBy('created_at', 'desc');
        }

        $services = $query->get();
        $categories = Category::all();

        return view('service-index', compact('services', 'categories'));
    }
    
    
    

    public function update(Request $request, Service $Service){
        $validated = $request->validate([
            'name' => 'required|min:5|max:200',
            'description' => 'required|min:14|max:500',
            'price' => [
                'required',
                function ($attribute, $value, $fail) {
                    $cleaned = str_replace(['R$', '.', ','], ['', '', '.'], $value);
                    if (!is_numeric($cleaned) || floatval($cleaned) <= 0) {
                        $fail('O campo preço deve ser um número válido maior que zero.');}}],
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',            
            'images' => 'sometimes|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cleanPrice = str_replace(['R$', '.', ','], ['', '', '.'], $request->price);
        $priceValue = floatval($cleanPrice);
        $userId = Auth::user()->id;

        $Service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $priceValue,
            'user_id' => $userId,
            'activated' => !$request->boolean('activated'),
        ]);
        
        // Atualiza categorias (sempre)
        $Service->categories()->sync($request->categories);
        
        // Só atualiza imagens se o usuário enviou novas
        if ($request->hasFile('images')) {
            // Apaga imagens antigas do banco e opcionalmente do disco
            foreach ($Service->ServiceImage() as $img) {
                $imagePath = public_path($img->url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $Service->ServiceImage()->delete();
        
            // Adiciona novas imagens
            $order = 1;
            foreach ($request->file('images') as $imageFile) {
                if ($imageFile->isValid()) {
                    $extension = $imageFile->extension();
                    $imageName = md5($imageFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $imageFile->move(public_path('img/services'), $imageName);
        
                    ServiceImage::create([
                        'service_id' => $Service->id,
                        'url' => 'img/services/' . $imageName,
                        'order' => $order,
                    ]);
        
                    $order++;
                }
            }
        }
        
        return back()->with('success', 'Serviço atualizado com sucesso!');
    }
    
    public function destroy(Service $service)
    {
    $currentUser = Auth::user();

    // Permitir apagar apenas se for dono OU admin
    if ($currentUser->id !== $service->user_id && !$currentUser->isAdmin()) {
        return redirect()->back()->with('error', 'Você não tem permissão para excluir este serviço.');
    }

    // Apagar imagens do disco
    foreach ($service->ServiceImage as $img) {
        $imagePath = public_path($img->url);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Apagar relações no banco
    $service->ServiceImage()->delete();
    $service->categories()->detach();

    // Apagar o próprio serviço
    $service->delete();

    return redirect()->route('service-index')->with('success', 'Serviço excluído com sucesso.');
    }
}
