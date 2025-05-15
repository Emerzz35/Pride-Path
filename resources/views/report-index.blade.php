@extends('layouts.app')

@section('content')
<main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Cabeçalho da página -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-titulo mb-2">Gerenciamento de Denúncias</h1>
            <p class="text-lg text-destaque">Analise e tome ações sobre o conteúdo reportado</p>
        </div>

        <!-- Formulário de busca e filtros -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('report-index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-titulo mb-1">Buscar</label>
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
                            placeholder="Buscar por palavras-chave..."
                            class="pl-10 w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                    </div>
                </div>

                <div class="md:w-64">
                    <label for="type" class="block text-sm font-medium text-titulo mb-1">Tipo de denúncia</label>
                    <select 
                        name="type" 
                        id="type"
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque appearance-none"
                    >
                        <option value="">Todos os tipos</option>
                        <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Usuário</option>
                        <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Serviço</option>
                        <option value="order" {{ request('type') == 'order' ? 'selected' : '' }}>Pedido</option>
                        <option value="comission" {{ request('type') == 'comission' ? 'selected' : '' }}>Entrega</option>
                        <option value="rating" {{ request('type') == 'rating' ? 'selected' : '' }}>Avaliação</option>
                    </select>
                </div>

                <div class="md:ml-2">
                    <button 
                        type="submit"
                        class="w-full md:w-auto px-6 py-3 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filtrar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de denúncias -->
        @if(count($reports) > 0)
            <div class="space-y-6">
                @foreach ($reports as $report)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-wrap justify-between items-start mb-4">
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if($report->reportable_type == 'App\\Models\\User') bg-blue-100 text-blue-800
                                        @elseif($report->reportable_type == 'App\\Models\\Service') bg-green-100 text-green-800
                                        @elseif($report->reportable_type == 'App\\Models\\Order') bg-purple-100 text-purple-800
                                        @elseif($report->reportable_type == 'App\\Models\\Comission') bg-yellow-100 text-yellow-800
                                        @elseif($report->reportable_type == 'App\\Models\\Rating') bg-red-100 text-red-800
                                        @endif">
                                        {{ class_basename($report->reportable_type) }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">Reportado por <span class="font-medium">{{ $report->user->name }}</span> em {{ $report->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <form action="{{ route('report-destroy', $report->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar esta denúncia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200 text-sm">
                                        Deletar denúncia
                                    </button>
                                </form>
                            </div>

                            <div class="border-t border-b border-gray-200 py-4 my-4">
                                <h3 class="text-lg font-semibold text-titulo mb-2">Motivo da denúncia</h3>
                                <p class="text-destaque">{{ $report->reason }}</p>
                            </div>

                            @php $target = $report->reportable; @endphp

                            <div class="bg-gray-50 rounded-lg p-4">
                                @if ($target instanceof App\Models\User)
                                    <div class="flex items-center mb-3">
                                        <img src="/img/profile/{{ $target->image }}" alt="{{ $target->name }}" class="w-10 h-10 rounded-full mr-3 object-cover">
                                        <div>
                                            <h3 class="font-semibold text-titulo">{{ $target->name }}</h3>
                                            <p class="text-sm text-gray-500">Usuário</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('profile', $target->id) }}" class="inline-flex items-center px-4 py-2 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver Perfil
                                        </a>
                                    </div>

                                @elseif ($target instanceof App\Models\Service)
                                    <h3 class="font-semibold text-titulo text-lg mb-2">{{ $target->name }}</h3>
                                    <p class="text-destaque mb-4">{{ Str::limit($target->description, 150) }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('service-show', $target->id) }}" class="inline-flex items-center px-4 py-2 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver Serviço
                                        </a>
                                    </div>

                                @elseif ($target instanceof App\Models\Order)
                                    <div class="space-y-2 mb-4">
                                        <div class="flex justify-between">
                                            <h3 class="font-semibold text-titulo">Pedido #{{ $target->id }}</h3>
                                            <span class="text-sm text-gray-500">Solicitado por: {{ $target->user->name }}</span>
                                        </div>
                                        <p class="font-medium">{{ $target->name }}</p>
                                        <p class="text-destaque">{{ $target->description }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('profile', $target->user->id) }}" class="inline-flex items-center px-4 py-2 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver Perfil do Solicitante
                                        </a>
                                    </div>

                                @elseif ($target instanceof App\Models\Comission)
                                    <div class="space-y-2 mb-4">
                                        <div class="flex justify-between">
                                            <h3 class="font-semibold text-titulo">Entrega #{{ $target->id }}</h3>
                                            <span class="text-sm text-gray-500">Prestador: {{ $target->order->service->user->name }}</span>
                                        </div>
                                        <p class="font-medium">{{ $target->name }}</p>
                                        <p class="text-destaque">{{ $target->description }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('profile', $target->order->service->user->id) }}" class="inline-flex items-center px-4 py-2 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver Perfil do Prestador
                                        </a>
                                    </div>

                                @elseif ($target instanceof App\Models\Rating)
                                    <div class="space-y-3 mb-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-semibold text-titulo">Avaliação para: {{ $target->service->name }}</h3>
                                                <p class="text-sm text-gray-500">Por: {{ $target->user->name }}</p>
                                            </div>
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $target->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.2 3.674a1 1 0 00.95.69h3.862c.969 0 1.371 1.24.588 1.81l-3.125 2.27a1 1 0 00-.364 1.118l1.2 3.674c.3.921-.755 1.688-1.538 1.118l-3.125-2.27a1 1 0 00-1.176 0l-3.125 2.27c-.783.57-1.838-.197-1.538-1.118l1.2-3.674a1 1 0 00-.364-1.118L2.45 9.1c-.783-.57-.38-1.81.588-1.81h3.862a1 1 0 00.95-.69l1.2-3.674z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        @if($target->comment)
                                            <p class="text-destaque italic">"{{ $target->comment }}"</p>
                                        @else
                                            <p class="text-gray-500 italic">Nenhum comentário</p>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('service-show', $target->service->id) }}" class="inline-flex items-center px-4 py-2 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver Serviço
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-destaque opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-titulo">Nenhuma denúncia encontrada</h3>
                <p class="mt-1 text-destaque">Não há denúncias para exibir com os filtros atuais.</p>
                <div class="mt-6">
                    <a href="{{ route('report-index') }}" class="text-link hover:text-opacity-80">
                        Limpar filtros <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
