@extends('layouts.app')

@section('content')
<main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Cabeçalho da página -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-titulo mb-2">
                @if (request()->route()->getName() == 'order-list')
                    Meus Pedidos
                @else
                    Pedidos Recebidos
                @endif
            </h1>
            <p class="text-lg text-destaque">
                @if (request()->route()->getName() == 'order-list')
                    Acompanhe o status dos seus pedidos
                @else
                    Gerencie os pedidos que você recebeu
                @endif
            </p>
        </div>

        <!-- Formulário de pesquisa e filtros -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ url()->current() }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
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
                            placeholder="Buscar por título ou descrição"
                            class="pl-10 w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                    </div>
                </div>

                <div class="md:w-64">
                    <label for="status" class="block text-sm font-medium text-titulo mb-1">Status</label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque appearance-none"
                    >
                        <option value="">Todos os status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
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

        <!-- Lista de pedidos -->
        @if(count($orders) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer order" data-modal-id="{{ $order->id }}">
                        <div class="h-48 overflow-hidden">
                            <img 
                                src="/{{ $order->Service->ServiceImage->first()->url }}" 
                                alt="{{ $order->Service->name }}"
                                class="w-full h-full object-cover order-image"
                                data-modal-id="{{ $order->id }}"
                            >
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-titulo line-clamp-1">{{ $order->name }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($order->Status->name == 'em produção') bg-blue-100 text-blue-800
                                    @elseif($order->Status->name == 'em analise') bg-yellow-100 text-yellow-800
                                    @elseif($order->Status->name == 'entregue') bg-green-100 text-green-800
                                    @elseif($order->Status->name == 'negado') bg-red-100 text-red-800
                                    @endif">
                                    {{ $order->Status->name }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-3">Serviço: <span class="font-medium">{{ $order->Service->name }}</span></p>
                            
                            <div class="flex items-center mt-4">
                                @if ($order->Service->User->id == Auth()->user()->id)
                                    <p class="text-sm text-gray-600">Cliente: <a href="/profile/{{ $order->user_id }}" class="text-link hover:underline">{{ $order->User->name }}</a></p>
                                @else
                                    <p class="text-sm text-gray-600">Prestador: <a href="/profile/{{ $order->Service->User->id }}" class="text-link hover:underline">{{ $order->Service->User->name }}</a></p>
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
                <h3 class="mt-2 text-lg font-medium text-titulo">Nenhum pedido encontrado</h3>
                <p class="mt-1 text-destaque">Não há pedidos para exibir com os filtros atuais.</p>
                <div class="mt-6">
                    <a href="{{ url()->current() }}" class="text-link hover:text-opacity-80">
                        Limpar filtros <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Modais para cada pedido -->
        @foreach ($orders as $order)
            <x-modal id="{{ $order->id }}">
                <div class="flex items-center justify-between mb-6 w-full">
                    <h1 class="text-2xl font-bold text-titulo">Detalhes do Pedido</h1>
                    <x-jam-close class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700 close-modal" data-modal-id="{{ $order->id }}"/>
                </div>

                <div class="w-full max-h-[70vh] overflow-y-auto pr-2 space-y-6">
                    <!-- Informações do pedido -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h2 class="text-lg font-semibold text-titulo mb-2">{{ $order->name }}</h2>
                        <p class="text-destaque mb-4">{{ $order->description }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($order->Status->name == 'em produção') bg-blue-100 text-blue-800
                                @elseif($order->Status->name == 'em analise') bg-yellow-100 text-yellow-800
                                @elseif($order->Status->name == 'entregue') bg-green-100 text-green-800
                                @elseif($order->Status->name == 'negado') bg-red-100 text-red-800
                                @endif">
                                Status: {{ $order->Status->name }}
                            </span>
                            
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                Serviço: {{ $order->Service->name }}
                            </span>
                        </div>
                        
                        <div class="flex items-center">
                            @if ($order->Service->User->id == Auth()->user()->id)
                                <p>Cliente: <a href="/profile/{{ $order->user_id }}" class="text-link hover:underline">{{ $order->User->name }}</a></p>
                            @else
                                <p>Prestador: <a href="/profile/{{ $order->Service->User->id }}" class="text-link hover:underline">{{ $order->Service->User->name }}</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- Ações específicas baseadas no status e papel do usuário -->
                    @if ($order->Service->User->id == Auth()->user()->id)
                        <!-- Prestador de serviço -->
                        @if ($order->Status->name == 'em analise')
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-titulo">Ações disponíveis</h3>
                                <div class="flex flex-wrap gap-3">
                                    <form action="{{ route('order-accept') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition-colors duration-200">
                                            Aceitar pedido
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('order-deny') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200">
                                            Negar pedido
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold text-titulo mb-3">Reportar pedido</h3>
                                    <form action="{{ route('report-store') }}" method="POST" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="type" value="order">
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <textarea 
                                            name="reason" 
                                            placeholder="Descreva o motivo da denúncia" 
                                            required
                                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                                            rows="3"
                                        ></textarea>
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200">
                                            Reportar pedido
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif ($order->Status->name == 'em produção')
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-titulo">Enviar entrega</h3>
                                <form action="{{ route('order-comission') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-titulo mb-1">Título da entrega</label>
                                        <input 
                                            type="text" 
                                            name="name" 
                                            id="name" 
                                            placeholder="Ex: Entrega final do projeto" 
                                            value="{{ old('name') }}"
                                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('name') border-red-500 @enderror"
                                            required
                                        >
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-titulo mb-1">Descrição da entrega</label>
                                        <textarea 
                                            name="description" 
                                            id="description" 
                                            placeholder="Descreva detalhes sobre a entrega e inclua links para arquivos se necessário" 
                                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque @error('description') border-red-500 @enderror"
                                            rows="4"
                                            required
                                        >{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                                        @enderror
                                    </div>
                                    
                                    <p class="text-sm text-gray-500">Se precisar enviar arquivos, coloque-os no Google Drive ou em algum serviço similar e inclua os links na descrição.</p>
                                    
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    
                                    <div class="pt-2">
                                        <button type="submit" class="bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200">
                                            Enviar entrega
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif ($order->Status->name == 'negado')
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                <p class="text-red-800">Você negou este pedido.</p>
                            </div>
                        @elseif ($order->Status->name == 'entregue')
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <p class="text-green-800">Pedido entregue com sucesso!</p>
                            </div>
                        @endif
                    @else
                        <!-- Cliente -->
                        @if ($order->Status->name == 'em analise')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                                <p class="text-yellow-800">Seu pedido está sendo analisado por <a href="/profile/{{ $order->Service->User->id }}" class="text-link hover:underline">{{ $order->Service->User->name }}</a>.</p>
                            </div>
                        @elseif ($order->Status->name == 'em produção')
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <p class="text-blue-800">Seu pedido está sendo produzido por <a href="/profile/{{ $order->Service->User->id }}" class="text-link hover:underline">{{ $order->Service->User->name }}</a>.</p>
                            </div>
                        @elseif ($order->Status->name == 'negado')
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                <p class="text-red-800">Infelizmente seu pedido foi negado por <a href="/profile/{{ $order->Service->User->id }}" class="text-link hover:underline">{{ $order->Service->User->name }}</a>.</p>
                            </div>
                        @elseif ($order->Status->name == 'entregue')
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-titulo">Entrega recebida</h3>
                                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                    <h4 class="font-medium text-green-800 mb-2">{{ $order->Comission->first()->name }}</h4>
                                    <p class="text-green-700 whitespace-pre-line">{{ $order->Comission->first()->description }}</p>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold text-titulo mb-3">Reportar entrega</h3>
                                    <form action="{{ route('report-store') }}" method="POST" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="type" value="comission">
                                        <input type="hidden" name="id" value="{{ $order->Comission->first()->id }}">
                                        <textarea 
                                            name="reason" 
                                            placeholder="Descreva o motivo da denúncia" 
                                            required
                                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                                            rows="3"
                                        ></textarea>
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200">
                                            Reportar entrega
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </x-modal>
        @endforeach
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Abrir modal ao clicar no container ou na imagem
        document.querySelectorAll('.order, .order-image').forEach(item => {
            item.addEventListener('click', (e) => {
                const modalId = e.currentTarget.getAttribute('data-modal-id');
                const boxModal = document.getElementById(modalId);

                if (boxModal) {
                    boxModal.classList.remove('hidden');
                    boxModal.classList.add('flex');
                }
            });
        });

        // Fechar modal ao clicar no botão de fechar
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation(); // Evita reabrir ao clicar no botão
                const modalId = e.currentTarget.getAttribute('data-modal-id');
                const boxModal = document.getElementById(modalId);

                if (boxModal) {
                    boxModal.classList.remove('flex');
                    boxModal.classList.add('hidden');
                }
            });
        });

        // Abrir modal automaticamente se sessão tiver 'show_modal'
        @if(session('show_modal'))
        const autoModalId = "{{ session('show_modal') }}";
        const autoModal = document.getElementById(autoModalId);
        if (autoModal) {
            autoModal.classList.remove('hidden');
            autoModal.classList.add('flex');
        }
        @endif
    });
</script>
@endpush
