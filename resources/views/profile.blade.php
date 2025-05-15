@extends('layouts.app')

@section('content')
<main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Cabeçalho do perfil -->
            <div class="md:flex">
                <!-- Foto de perfil e informações básicas -->
                <div class="md:w-1/3 p-6 flex flex-col items-center border-b md:border-b-0 md:border-r border-gray-200">
                    <div class="relative mb-4">
                        <div class="w-40 h-40 rounded-full overflow-hidden ring-4 ring-destaque">
                            <img 
                                src="/img/profile/{{ $User->image }}" 
                                alt="{{ $User->name }}" 
                                class="w-full h-full object-cover"
                                @if ($User->id === Auth()->user()->id) id='profile-picture' class="cursor-pointer" @endif
                            >
                        </div>
                        @if ($User->id === Auth()->user()->id)
                            <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md">
                                <svg class="w-6 h-6 text-destaque" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <h1 class="text-2xl font-bold text-titulo mb-4">{{ $User->name }}</h1>
                    
                    <!-- Avaliação média -->
                    <div class="mb-6 text-center">
                        <h2 class="text-lg font-semibold text-titulo mb-2">Média de Avaliações</h2>

                        @if ($overallAverage)
                            @php
                                $fullStars = floor($overallAverage);
                                $decimal = $overallAverage - $fullStars;
                                $halfStar = $decimal >= 0.25 && $decimal < 0.75;
                                $almostFull = $decimal >= 0.75;
                                $emptyStars = 5 - $fullStars - ($halfStar || $almostFull ? 1 : 0);
                            @endphp

                            <div class="flex items-center justify-center mt-2 text-yellow-400">
                                {{-- Estrelas cheias --}}
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/>
                                    </svg>
                                @endfor

                                {{-- Estrela quase cheia --}}
                                @if ($almostFull)
                                    <svg class="w-6 h-6" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="star90">
                                                <stop offset="90%" stop-color="currentColor"/>
                                                <stop offset="90%" stop-color="transparent"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#star90)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/>
                                    </svg>
                                @elseif ($halfStar)
                                    <svg class="w-6 h-6" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="halfGrad">
                                                <stop offset="50%" stop-color="currentColor" />
                                                <stop offset="50%" stop-color="transparent" />
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#halfGrad)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/>
                                    </svg>
                                @endif

                                {{-- Estrelas vazias --}}
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/>
                                    </svg>
                                @endfor

                                <span class="ml-2 text-gray-700 font-medium">{{ number_format($overallAverage, 1) }}/5</span>
                            </div>
                        @else
                            <p class="text-gray-500">Este usuário ainda não possui avaliações.</p>
                        @endif
                    </div>
                    
                    <!-- Botões de ação -->
                    <div class="w-full space-y-4">
                        @if ($User->id === Auth()->user()->id) 
                            <x-button 
                                class="mt-5 w-full bg-botao text-white px-4 py-2 rounded-xl hover:bg-blue-950 transition-colors duration-200 flex items-center justify-center"
                                linkto='user-edit'
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar perfil
                            </x-button>
                            
                            <x-button 
                                class="mt-5 w-full bg-input text-destaque px-4 py-2 rounded-xl hover:bg-gray-200 transition-colors duration-200 flex items-center justify-center"
                                linkto='order-list'
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Meus pedidos
                            </x-button>
                            
                            <x-button 
                                class="mt-5 w-full bg-input text-destaque px-4 py-2 rounded-xl hover:bg-gray-200 transition-colors duration-200 flex items-center justify-center"
                                linkto='order-received'
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                Minhas entregas
                            </x-button>
                            
                            <x-button 
                                class="mt-5 w-full bg-link text-white px-4 py-2 rounded-xl hover:bg-purple-800 transition-colors duration-200 flex items-center justify-center"
                                linkto='service-create'
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Postar serviço
                            </x-button>
                            
                            @if (Auth::id() === $User->id || Auth::user()->isAdmin())
                                <form action="{{ route('user-destroy', $User->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" mt-5 w-full bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Excluir conta
                                    </button>
                                </form>
                            @endif
                        @else
                            <x-button 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200 flex items-center justify-center"
                                id='reportar-servico'
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Reportar perfil
                            </x-button>
                            
                            @if (Auth::user()->isAdmin())
                                <form action="{{ route('user-destroy', $User->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" mt-5 w-full bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Excluir usuário (Admin)
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
                
                <!-- Serviços do usuário -->
                <div class="md:w-2/3 p-6">
                    <h2 class="text-xl font-bold text-titulo mb-4">Serviços oferecidos</h2>
                    
                    @if(count($User->Service) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($User->Service as $service)
                                @if ($service->activated == true or $User->id === Auth()->user()->id)
                                    <a href="{{ route('service-show', $service->id) }}" class="group">
                                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden transition-transform duration-300 hover:shadow-md hover:-translate-y-1 h-full flex flex-col">
                                            <div class="h-40 overflow-hidden">
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
                                                    
                                                    @if($User->id === Auth()->user()->id && !$service->activated)
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                            Desativado
                                                        </span>
                                                    @endif
                                                    
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
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum serviço encontrado</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if($User->id === Auth()->user()->id)
                                    Você ainda não publicou nenhum serviço.
                                @else
                                    Este usuário ainda não publicou nenhum serviço.
                                @endif
                            </p>
                            @if($User->id === Auth()->user()->id)
                                <div class="mt-6">
                                    <x-button 
                                        class="inline-flex items-center px-4 py-2 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                                        linkto='service-create'
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Publicar meu primeiro serviço
                                    </x-button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal de atualização de foto de perfil -->
@if ($User->id === Auth()->user()->id) 
<x-modal id="box-modal">
    <div class="flex items-center justify-between mb-4 w-full">
        <h1 class="text-2xl font-bold text-titulo">Atualizar foto de perfil</h1>
        <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700" id="close-modal"/>
    </div>

    <div class="w-full">
        <form method="POST" action="{{ route('user-updateImage') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')
            
            <div class="bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque">
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="w-full text-sm text-destaque"
                    accept=".jpeg,.png,.jpg"
                />
            </div>
            <p class="text-sm text-gray-500">Selecione uma imagem nos formatos JPG, JPEG ou PNG.</p>
            
            <div class="flex justify-end pt-2">
                <x-button 
                    class="bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                    linkto='user-updateImage'>
                    Atualizar foto
                </x-button>
            </div>
        </form>
    </div>
</x-modal>
@endif

<!-- Modal de reportar perfil -->
<x-modal id="report-modal">
    <div class="flex items-center justify-between mb-4 w-full">
        <h1 class="text-2xl font-bold text-titulo">Reportar {{ $User->name }}</h1>
        <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700" id="close-modal-report"/>
    </div>

    <div class="w-full">
        <form action="{{ route('report-store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="type" value="user">
            <input type="hidden" name="id" value="{{ $User->id }}">
            
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
            
            <div class="flex justify-end pt-2">
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

@push('scripts')
    <script>
        const profilePicture = document.getElementById('profile-picture')
        const boxModal = document.getElementById('box-modal') 
        const closeModal = document.getElementById('close-modal') 
         
        if (profilePicture && boxModal && closeModal) {
            profilePicture.addEventListener('click', () => {
                boxModal.classList.remove('hidden')
                boxModal.classList.add('flex')   
            })

            closeModal.addEventListener('click', () => {
                boxModal.classList.remove('flex')
                boxModal.classList.add('hidden')   
            })
        }
        
        @if(session('show_modal'))
        window.addEventListener('DOMContentLoaded', () => {
            if (boxModal) {
                boxModal.classList.remove('hidden')
                boxModal.classList.add('flex')   
            }
        })
        @endif
    </script>
    
    <script>
        const reportarServico = document.getElementById('reportar-servico')
        const reportModal = document.getElementById('report-modal') 
        const closeModalReport = document.getElementById('close-modal-report') 
         
        if (reportarServico && reportModal && closeModalReport) {
            reportarServico.addEventListener('click', (event) => {
                event.preventDefault();
                reportModal.classList.remove('hidden')
                reportModal.classList.add('flex')   
            })

            closeModalReport.addEventListener('click', () => {
                reportModal.classList.remove('flex')
                reportModal.classList.add('hidden')   
            })
        }
    </script>
    
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
@endpush
