<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceImage;

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

    }

    public function show(Service $Service){
        $Services = Service::all();
        $categories = Category::all();
        $serviceCategories = $Service->categories->pluck('id')->toArray();
        return view('service-show')
            ->with('Service', $Service)
            ->with('categories', $categories)
            ->with('serviceCategories', $serviceCategories);
    }

    public function index(Request $request) {
        $query = Service::with(['ServiceImage', 'categories'])->where('activated', 1);
    
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }
    
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
}
