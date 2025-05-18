@extends('layouts.app')

@if ($Service->activated == 1 or $Service->user->id === Auth()->user()->id)
    @section('content')
    <main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Galeria de imagens e informações principais -->
                <div class="md:flex">
                    <!-- Galeria de imagens -->
                    <div class="md:w-1/2 relative">
                        @if(count($Service->ServiceImage) > 1)
                            <!-- Carrossel Flowbite para múltiplas imagens -->
                            <div id="service-carousel" class="relative w-full h-96" data-carousel="slide">
                                <!-- Carousel wrapper -->
                                <div class="relative h-full overflow-hidden rounded-lg">
                                    @foreach ($Service->ServiceImage as $index => $Image)
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                                            <img src="/{{ $Image->url }}" 
                                                 alt="{{ $Service->name }}" 
                                                 class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Slider indicators -->
                                <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                                    @foreach ($Service->ServiceImage as $index => $Image)
                                        <button type="button" 
                                                class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800" 
                                                aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                                aria-label="Slide {{ $index + 1 }}" 
                                                data-carousel-slide-to="{{ $index }}">
                                        </button>
                                    @endforeach
                                </div>
                                
                                <!-- Slider controls -->
                                <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                        <span class="sr-only">Anterior</span>
                                    </span>
                                </button>
                                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                        <span class="sr-only">Próximo</span>
                                    </span>
                                </button>
                            </div>
                        @else
                            <!-- Imagem única -->
                            <div class="h-96">
                                <img 
                                    src="/{{ $Service->ServiceImage->first()->url }}" 
                                    alt="{{ $Service->name }}" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        @endif
                    </div>

                    <!-- Informações principais -->
                    <div class="md:w-1/2 p-6 md:p-8">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($Service->categories as $category)
                                <span class="bg-destaque bg-opacity-90 text-white text-xs px-3 py-1 rounded-full">
                                    {{$category->name}}
                                </span>
                            @endforeach
                        </div>

                        <h1 class="text-3xl font-bold text-titulo mb-2">{{ $Service->name }}</h1>
                        
                        <!-- Avaliação média -->
                        <div class="flex items-center mb-4">
                            @php
                                $rating = $Service->averageRating(); // Ex: 3.5
                                $fullStars = floor($rating);         // Ex: 3
                                $halfStar = ($rating - $fullStars) >= 0.25 && ($rating - $fullStars) < 0.75; // Mostrar meia estrela
                                $almostFull = ($rating - $fullStars) >= 0.75; // Mostrar estrela quase cheia
                                $emptyStars = 5 - $fullStars - ($halfStar || $almostFull ? 1 : 0);
                            @endphp

                            <div class="flex items-center text-yellow-500 mr-2">
                                {{-- Estrelas inteiras --}}
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
                                @endfor

                                {{-- Estrela quase cheia (maior que 0.75) --}}
                                @if($almostFull)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><defs><linearGradient id="star90"><stop offset="90%" stop-color="currentColor"/><stop offset="90%" stop-color="transparent"/></linearGradient></defs><path fill="url(#star90)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
                                @elseif($halfStar)
                                    {{-- Meia estrela --}}
                                    <svg class="w-5 h-5" viewBox="0 0 20 20">
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
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">({{ $Service->ratings->count() }} avaliações)</span>
                        </div>

                        <!-- Preço -->
                        <div class="text-3xl font-bold text-link mb-6">
                            R$ {{ number_format($Service->price, 2, ',', '.') }}
                        </div>

                        <!-- Descrição -->
                        <div class="text-destaque mb-8">
                            <h3 class="text-lg font-semibold text-titulo mb-2">Descrição</h3>
                            <p>{{ $Service->description }}</p>
                        </div>

                        <!-- Prestador do serviço -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-titulo mb-2">Prestador</h3>
                            <a href="/profile/{{  $Service->user_id }}" class="flex items-center group">
                                <img src="/img/profile/{{ $Service->user->image }}" alt="{{ $Service->user->name }}" class="w-10 h-10 rounded-full mr-3 object-cover">
                                <span class="text-link group-hover:underline">{{ $Service->user->name }}</span>
                            </a>
                        </div>

                        <!-- Botões de ação -->
                        <div class="flex flex-wrap gap-3">
                            @if ($Service->user->id === Auth()->user()->id)
                                <x-button class='bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200' id='editar-servico'>
                                    Editar Serviço
                                </x-button>
                                
                                @if (Auth::id() === $Service->user_id || Auth::user()->isAdmin())
                                    <form action="{{ route('service-destroy', $Service->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition-colors duration-200">
                                            Excluir Serviço
                                        </button>
                                    </form>
                                @endif
                            @else
                                <x-button class='bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200' id='fazer-pedido'>
                                    Fazer pedido
                                </x-button>
                                
                                <x-button class='bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition-colors duration-200' id='reportar-servico'>
                                    Reportar serviço
                                </x-button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Seção de avaliação do usuário (se não avaliou ainda) -->
                @if (!$ratingExists && $Service->user->id !== Auth()->user()->id && $hasMadeOrder)
                    <div class="border-t border-gray-200 p-6 md:p-8 bg-gray-50">
                        <h2 class="text-xl font-bold text-titulo mb-4">Avalie este serviço</h2>
                        <form id="rating-form" action="{{ route('service-rate', $Service->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="rating" id="rating-value">

                            <div id="star-rating" class="flex space-x-2 text-3xl text-gray-300 cursor-pointer">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star transition-colors duration-200" data-value="{{ $i }}">&#9733;</span>
                                @endfor
                            </div>

                            <p id="rating-text" class="text-sm text-gray-500"></p>

                            <textarea name="comment" class="w-full p-4 bg-input rounded-xl focus:outline-none focus:ring-2 focus:ring-destaque" placeholder="Comentário (opcional)" maxlength="500"></textarea>
                            
                            <button type="submit" class="bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200">
                                Enviar Avaliação
                            </button>
                        </form>
                    </div>
                @elseif (!$ratingExists && $Service->user->id !== Auth()->user()->id && !$hasMadeOrder)
                    <div class="border-t border-gray-200 p-6 md:p-8 bg-gray-50">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Para avaliar este serviço, você precisa primeiro fazer um pedido.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Seção de avaliações -->
                <div class="border-t border-gray-200 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-titulo mb-6">Avaliações</h2>

                    @forelse ($ratings as $rating)
                        <div class="mb-8 border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <img src="/img/profile/{{$rating->user->image }}" alt="{{ $rating->user->name }}" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <span class="font-semibold text-titulo block">{{ $rating->user->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.2 3.674a1 1 0 00.95.69h3.862c.969 0 1.371 1.24.588 1.81l-3.125 2.27a1 1 0 00-.364 1.118l1.2 3.674c.3.921-.755 1.688-1.538 1.118l-3.125-2.27a1 1 0 00-1.176 0l-3.125 2.27c-.783.57-1.838-.197-1.538-1.118l1.2-3.674a1 1 0 00-.364-1.118L2.45 9.1c-.783-.57-.38-1.81.588-1.81h3.862a1 1 0 00.95-.69l1.2-3.674z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            @if($rating->comment)
                                <p class="text-destaque mb-4">{{ $rating->comment }}</p>
                            @endif
                            
                            <div class="flex gap-3 mt-3">
                                @if ($rating->user_id === Auth::id())
                                    <form action="{{ route('rating-destroy', ['serviceId' => $Service->id]) }}" method="POST" onsubmit="return confirm('Deseja excluir sua avaliação?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Excluir minha avaliação</button>
                                    </form>
                                @else
                                    <x-button class='text-sm text-link hover:underline' id='reportar-rating-{{ $rating->id }}'>
                                        Reportar avaliação
                                    </x-button>
                                    
                                    <x-modal id="report-rating-modal-{{ $rating->id }}">
                                        <div class="flex items-center justify-between mb-4 w-full">
                                            <h1 class="text-2xl font-bold text-titulo">Reportar Avaliação</h1>
                                            <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700" id="close-modal-report-rating-{{ $rating->id }}"/>
                                        </div>

                                        <div class="w-full">
                                            <form action="{{ route('report-store') }}" method="POST" class="space-y-4">
                                                @csrf
                                                <input type="hidden" name="type" value="rating">
                                                <input type="hidden" name="id" value="{{ $rating->id }}">
                                                
                                                <textarea name="reason" placeholder="Descreva o motivo" required class="w-full p-4 bg-input rounded-xl focus:outline-none focus:ring-2 focus:ring-destaque"></textarea>
                                                
                                                <div class="flex justify-end">
                                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200">
                                                        Reportar Avaliação
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </x-modal>
                                    
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const reportarRating{{ $rating->id }} = document.getElementById('reportar-rating-{{ $rating->id }}');
                                            const reportModalRating{{ $rating->id }} = document.getElementById('report-rating-modal-{{ $rating->id }}');
                                            const closeModalReportRating{{ $rating->id }} = document.getElementById('close-modal-report-rating-{{ $rating->id }}');
                                            
                                            reportarRating{{ $rating->id }}.addEventListener('click', function(event) {
                                                event.preventDefault();
                                                reportModalRating{{ $rating->id }}.classList.remove('hidden');
                                                reportModalRating{{ $rating->id }}.classList.add('flex');
                                            });
                                            
                                            closeModalReportRating{{ $rating->id }}.addEventListener('click', function() {
                                                reportModalRating{{ $rating->id }}.classList.remove('flex');
                                                reportModalRating{{ $rating->id }}.classList.add('hidden');
                                            });
                                        });
                                    </script>
                                @endif

                                @if (Auth::user()->isAdmin())
                                    <form action="{{ route('rating-destroy', ['serviceId' => $rating->service_id, 'userId' => $rating->user_id]) }}" method="POST" onsubmit="return confirm('Deseja excluir esta avaliação?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Excluir avaliação (Admin)</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Ainda não há avaliações para este serviço.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de edição de serviço -->
    <x-modal id="edit-service-modal">
        <div class="flex items-center justify-between mb-4 w-full">
            <h1 class="text-2xl font-bold text-titulo">Editar Serviço</h1>
            <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700" id="close-modal-edit"/>
        </div>

        <div class="w-full max-h-[70vh] overflow-y-auto pr-2">
            <form action="{{ route('service-update', $Service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="name" class="block text-sm font-medium text-titulo mb-1">Título</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        placeholder="Título do serviço" 
                        value="{{ $Service->name }}"
                        class="w-full bg-input rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-destaque @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                    @enderror
                </div>
        
                <div>
                    <label for="description" class="block text-sm font-medium text-titulo mb-1">Descrição</label>
                    <textarea 
                        name="description" 
                        id="description"
                        placeholder="Descrição detalhada do serviço"
                        class="w-full bg-input rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-destaque @error('description') border-red-500 @enderror"
                        rows="3"
                    >{{ $Service->description }}</textarea>
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
                        placeholder="Preço" 
                        value="{{ $Service->price }}"
                        class="w-full bg-input rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-destaque @error('price') border-red-500 @enderror"
                    >
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                    @enderror
                </div>
        
                <div>
                    <label class="block text-sm font-medium text-titulo mb-1">Categorias</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach ($categories as $category)
                            <label class="flex items-center bg-input rounded-xl px-3 py-1 cursor-pointer hover:bg-opacity-80 transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="categories[]" 
                                    value="{{ $category->id }}" 
                                    {{ in_array($category->id, $serviceCategories) ? 'checked' : '' }}
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
                    <label class="block text-sm font-medium text-titulo mb-1">Imagens</label>
                    <div class="bg-input rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-destaque">
                        <input 
                            type="file" 
                            name="images[]" 
                            multiple 
                            accept=".jpeg,.png,.jpg"
                            class="w-full"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Selecione novas imagens para adicionar (opcional)</p>
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="activated" 
                        id="activated"
                        value="1" 
                        {{ !$Service->activated ? 'checked' : '' }}
                        class="mr-2 h-4 w-4 accent-destaque"
                    >
                    <label for="activated" class="text-sm text-destaque">Desativar serviço?</label>
                </div>

                <div class="flex justify-end pt-2">
                    <button 
                        type="submit"
                        class="bg-botao text-white px-5 py-2 rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                    >
                        Atualizar serviço
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal de fazer pedido -->
    @if ($Service->user->id !== Auth()->user()->id)
        <x-modal id="make-order-modal">
            <div class="flex items-center justify-between mb-6 w-full">
                <h1 class="text-2xl font-bold text-titulo">Fazer pedido</h1>
                <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700" id="close-modal-order"/>
            </div>

            <div class="w-full">
                <form action="{{ route('order-store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="order-name" class="block text-sm font-medium text-titulo mb-1">Título do pedido</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="order-name"
                            placeholder="Ex: Preciso deste serviço para..." 
                            value="{{ old('name') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('name') border-red-500 @enderror"
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
            
                    <div>
                        <label for="order-description" class="block text-sm font-medium text-titulo mb-1">Detalhes do pedido</label>
                        <textarea 
                            name="description" 
                            id="order-description"
                            placeholder="Descreva detalhadamente o que você precisa..."
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('description') border-red-500 @enderror"
                            rows="4"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>

                    <input type="hidden" name="service_id" value="{{ $Service->id }}">
            
                    <div class="flex justify-end pt-4">
                        <button 
                            type="submit"
                            class="bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                        >
                            Enviar pedido
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endif

    <!-- Modal de reportar serviço -->
    <x-modal id="report-service-modal">
        <div class="flex items-center justify-between mb-6 w-full">
            <h1 class="text-2xl font-bold text-titulo">Reportar serviço</h1>
            <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700" id="close-modal-report"/>
        </div>

        <div class="w-full">
            <form action="{{ route('report-store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="type" value="service">
                <input type="hidden" name="id" value="{{ $Service->id }}">
                
                <div>
                    <label for="reason" class="block text-sm font-medium text-titulo mb-1">Motivo da denúncia</label>
                    <textarea 
                        name="reason" 
                        id="reason"
                        placeholder="Descreva detalhadamente o motivo da denúncia..."
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        rows="4"
                        required
                    ></textarea>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button 
                        type="submit" 
                        class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition-colors duration-200"
                    >
                        Enviar denúncia
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
    @endsection
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal de editar serviço
            const editarServico = document.getElementById('editar-servico');
            const editServiceModal = document.getElementById('edit-service-modal');
            const closeModalEdit = document.getElementById('close-modal-edit');
             
            if (editarServico && editServiceModal && closeModalEdit) {
                editarServico.addEventListener('click', function(event) {
                    event.preventDefault();
                    editServiceModal.classList.remove('hidden');
                    editServiceModal.classList.add('flex');
                });
    
                closeModalEdit.addEventListener('click', function() {
                    editServiceModal.classList.remove('flex');
                    editServiceModal.classList.add('hidden');
                });
            }
            
            // Modal de fazer pedido
            const fazerPedido = document.getElementById('fazer-pedido');
            const makeOrderModal = document.getElementById('make-order-modal');
            const closeModalOrder = document.getElementById('close-modal-order');
             
            if (fazerPedido && makeOrderModal && closeModalOrder) {
                fazerPedido.addEventListener('click', function(event) {
                    event.preventDefault();
                    makeOrderModal.classList.remove('hidden');
                    makeOrderModal.classList.add('flex');
                });
    
                closeModalOrder.addEventListener('click', function() {
                    makeOrderModal.classList.remove('flex');
                    makeOrderModal.classList.add('hidden');
                });
            }
            
            // Modal de reportar serviço
            const reportarServico = document.getElementById('reportar-servico');
            const reportServiceModal = document.getElementById('report-service-modal');
            const closeModalReport = document.getElementById('close-modal-report');
             
            if (reportarServico && reportServiceModal && closeModalReport) {
                reportarServico.addEventListener('click', function(event) {
                    event.preventDefault();
                    reportServiceModal.classList.remove('hidden');
                    reportServiceModal.classList.add('flex');
                });
    
                closeModalReport.addEventListener('click', function() {
                    reportServiceModal.classList.remove('flex');
                    reportServiceModal.classList.add('hidden');
                });
            }
            
            // Formatação do campo de preço
            const priceInput = document.getElementById('price');
            
            if (priceInput) {
                priceInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');  
                    value = (value / 100).toFixed(2) + '';         
            
                    value = value.replace('.', ',');               
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    e.target.value = 'R$ ' + value;
                });
            }

            // Sistema de avaliação com estrelas
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating-value');
            const ratingText = document.getElementById('rating-text');
            const textMap = {
                1: 'Péssimo',
                2: 'Ruim',
                3: 'Regular',
                4: 'Bom',
                5: 'Excelente'
            };
            let selectedRating = 0;

            if (stars.length > 0 && ratingInput && ratingText) {
                stars.forEach(star => {
                    star.addEventListener('mouseover', () => {
                        const val = parseInt(star.dataset.value);
                        highlightStars(val);
                        ratingText.innerText = textMap[val];
                    });

                    star.addEventListener('mouseout', () => {
                        if (selectedRating === 0) {
                            highlightStars(0);
                            ratingText.innerText = '';
                        } else {
                            highlightStars(selectedRating);
                            ratingText.innerText = textMap[selectedRating];
                        }
                    });

                    star.addEventListener('click', () => {
                        selectedRating = parseInt(star.dataset.value);
                        ratingInput.value = selectedRating;
                        highlightStars(selectedRating);
                        ratingText.innerText = textMap[selectedRating];
                    });
                });

                function highlightStars(rating) {
                    stars.forEach(star => {
                        const val = parseInt(star.dataset.value);
                        if (val <= rating) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                }
            }
        });
    </script>
@endpush
