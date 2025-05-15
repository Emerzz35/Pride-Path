@extends('layouts.app')

@section('content')
<main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Cabeçalho da página -->
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-titulo">Publicar novo serviço</h1>
                <p class="text-destaque mt-1">Compartilhe seus talentos e habilidades com a comunidade</p>
            </div>

            <!-- Formulário -->
            <div class="p-6">
                <form action="{{ route('service-store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-titulo mb-1">Título do serviço</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            placeholder="Ex: Design de logotipos profissionais" 
                            value="{{ old('name') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('name') border-red-500 @enderror"
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
            
                    <div>
                        <label for="description" class="block text-sm font-medium text-titulo mb-1">Descrição detalhada</label>
                        <textarea 
                            name="description" 
                            id="description"
                            placeholder="Descreva detalhadamente o serviço que você oferece..."
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('description') border-red-500 @enderror"
                            rows="4"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
            
                    <div>
                        <label for="price" class="block text-sm font-medium text-titulo mb-1">Preço</label>
                        <input 
                            type="text" 
                            id="price" 
                            name="price" 
                            placeholder="R$ 0,00" 
                            value="{{ old('price') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('price') border-red-500 @enderror"
                        >
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
            
                    <div>
                        <label class="block text-sm font-medium text-titulo mb-2">Categorias</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach ($categories as $category)
                                <label class="flex items-center bg-input rounded-xl px-3 py-2 cursor-pointer hover:bg-opacity-80 transition-colors">
                                    <input 
                                        type="checkbox" 
                                        name="categories[]" 
                                        value="{{ $category->id }}" 
                                        class="mr-2 accent-destaque"
                                    >
                                    <span class="text-sm">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
            
                    <div>
                        <label class="block text-sm font-medium text-titulo mb-2">Imagens do serviço</label>
                        <div class="bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque">
                            <input 
                                type="file" 
                                name="images[]" 
                                multiple 
                                accept=".jpeg,.png,.jpg"
                                class="w-full"
                            >
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Adicione até 5 imagens para ilustrar seu serviço (máx. 2MB cada)</p>
                        @error('images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                   
                    <div class="pt-4 flex justify-end">
                        <x-button 
                            class="bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                            linkto='service-store'>
                            Publicar serviço
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dicas para um bom anúncio -->
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-titulo mb-4">Dicas para um bom anúncio</h2>
            
            <ul class="space-y-3 text-destaque">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Seja detalhado na descrição do seu serviço</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Adicione imagens de qualidade que mostrem bem o seu trabalho</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Escolha as categorias corretas para facilitar a busca</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Defina um preço justo e competitivo para o seu serviço</span>
                </li>
            </ul>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('price');

    priceInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');  
        value = (value / 100).toFixed(2) + '';         

        value = value.replace('.', ',');               
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 

        e.target.value = 'R$ ' + value;
    });
});
</script>
@endsection
