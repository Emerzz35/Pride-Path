@extends('layouts.app')

@section('content')
<main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Cabeçalho da página -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-titulo mb-2">Serviços disponíveis</h1>
            <p class="text-lg text-destaque">Encontre os melhores serviços para você</p>
        </div>

        <!-- Formulário de pesquisa e filtros -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('service-index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-titulo mb-1">Pesquisar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}" 
                            placeholder="O que você está procurando?"
                            class="pl-10 w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                    </div>
                </div>

                <div class="md:w-64">
                    <label for="category" class="block text-sm font-medium text-titulo mb-1">Categoria</label>
                    <select 
                        name="category" 
                        id="category"
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque appearance-none"
                    >
                        <option value="">Todas as categorias</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:ml-2">
                    <button 
                        type="submit"
                        class="w-full md:w-auto px-6 py-3 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 flex items-center justify-center"
                    >
                        <span>Buscar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Resultados da pesquisa -->
        @if(count($services) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($services as $service)
                    @if ($service->activated == 1)
                        <a href="{{ route('service-show', $service->id) }}" class="group">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1 h-full flex flex-col">
                                <div class="h-48 overflow-hidden">
                                    <img 
                                        src="/{{ $service->ServiceImage->first()->url }}" 
                                        alt="{{ $service->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    >
                                </div>
                                <div class="p-4 flex-1 flex flex-col">
                                    <h3 class="text-lg font-semibold text-titulo mb-1 line-clamp-1">{{ $service->name }}</h3>
                                    
                                    <!-- Avaliação média -->
                                    <div class="flex items-center mb-2">
                                        @php
                                            $rating = $service->averageRating(); // Ex: 3.5
                                            $fullStars = floor($rating);         // Ex: 3
                                            $halfStar = ($rating - $fullStars) >= 0.25 && ($rating - $fullStars) < 0.75; // Mostrar meia estrela
                                            $almostFull = ($rating - $fullStars) >= 0.75; // Mostrar estrela quase cheia
                                            $emptyStars = 5 - $fullStars - ($halfStar || $almostFull ? 1 : 0);
                                        @endphp

                                        <div class="flex items-center text-yellow-500 mr-1">
                                            {{-- Estrelas inteiras --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
                                            @endfor

                                            {{-- Estrela quase cheia (maior que 0.75) --}}
                                            @if($almostFull)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><defs><linearGradient id="star90"><stop offset="90%" stop-color="currentColor"/><stop offset="90%" stop-color="transparent"/></linearGradient></defs><path fill="url(#star90)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
                                            @elseif($halfStar)
                                                {{-- Meia estrela --}}
                                                <svg class="w-4 h-4" viewBox="0 0 20 20">
                                                    <defs>
                                                        <linearGradient id="halfGrad">
                                                            <stop offset="50%" stop-color="currentColor" />
                                                            <stop offset="50%" stop-color="transparent" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#halfGrad)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z" />
                                                </svg>
                                            @endif

                                            {{-- Estrelas vazias --}}
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-600">({{ $service->ratings->count() }})</span>
                                    </div>
                                    
                                    <p class="text-destaque text-sm mb-3 line-clamp-2">{{ $service->description }}</p>
                                    <div class="mt-auto">
                                        <span class="text-link font-bold">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                                        
                                        <div class="categories-wrapper mt-2 relative">
                                            <div class="categories-container overflow-x-auto py-1 pb-2 flex">
                                                @if($service->categories && $service->categories->count() > 0)
                                                    <div class="flex gap-1 flex-nowrap">
                                                        @foreach($service->categories as $category)
                                                            <span class="bg-destaque bg-opacity-90 text-white text-xs px-2 py-1 rounded-full whitespace-nowrap">
                                                                {{ $category->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                                        Sem categoria
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-r from-transparent to-white pointer-events-none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-destaque opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-titulo">Nenhum serviço encontrado</h3>
                <p class="mt-1 text-destaque">Tente ajustar seus filtros ou pesquisar por outro termo.</p>
                <div class="mt-6">
                    <a href="{{ route('service-index') }}" class="text-link hover:text-opacity-80">
                        Limpar filtros <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</main>

<style>
/* Adiciona truncamento de texto com reticências */
.line-clamp-1 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
}

.line-clamp-2 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

/* Estiliza a barra de rolagem para categorias */
.categories-container {
  scrollbar-width: thin;
  scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
}

.categories-container::-webkit-scrollbar {
  height: 4px;
}

.categories-container::-webkit-scrollbar-track {
  background: transparent;
}

.categories-container::-webkit-scrollbar-thumb {
  background-color: rgba(156, 163, 175, 0.5);
  border-radius: 20px;
}

/* Estilo para o container de categorias */
.categories-wrapper {
  position: relative;
  min-height: 30px;
}
</style>
@endsection
