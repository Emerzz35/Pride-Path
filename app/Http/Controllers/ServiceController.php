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
        return view('service-show')
            ->with('Service', $Service);
    }
    public function index(){
        $services = Service::all();
        return view('service-index')
        ->with('services', $services);
    }
}
