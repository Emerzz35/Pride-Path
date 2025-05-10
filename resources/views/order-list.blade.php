@extends('layouts.app')

@section('content')

<form method="GET" action=" {{ url()->current() }}">
    <label for="search">Pesquisar:</label>
    <input type="text" name="search" id="search" value="{{ request('search') }}">

    <label for="status">Filtrar por status:</label>
    <select name="status" id="status">
        <option value="">Todos os status</option>
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                {{ $status->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Buscar</button>
</form>


@foreach ($orders as $order)
<div class="order" data-modal-id="{{ $order->id }}">
    {{ $order->name }}
    {{ $order->Status->name }}

    {{ $order->Service->name }}
    <img 
        src="/{{ $order->Service->ServiceImage->first()->url }}" 
        alt="{{ $order->Service->name }}"
        class="order-image"
        data-modal-id="{{ $order->id }}"
    >

    @if ($order->Service->User->id == Auth()->user()->id)
        <a href="/profile/{{  $order->user_id }}"> {{ $order->User->name }} </a>
    @else
        <a href="/profile/{{  $order->Service->User->id }}"> {{ $order->Service->User->name }} </a>
    @endif 

    <x-modal id="{{ $order->id }}" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center">
        <div class="bg-white p-6 rounded">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Selecione uma foto de perfil</h1>
                <x-jam-close 
                    class="cursor-pointer text-gray-500 hover:text-gray-700 close-modal"
                    data-modal-id="{{ $order->id }}"
                />
            </div>


            @if ($order->Service->User->id == Auth()->user()->id)
            {{-- Pedidos a entregar --}}
                @if ($order->Status->name == 'em analise')
                    <form action="{{ route('order-accept') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <x-button linkto='order-accept'>Aceitar pedido</x-button>
                    </form>
                    <form action="{{ route('order-deny') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <x-button linkto='order-deny'>Negar pedido</x-button>
                    </form>
                @elseif ($order->Status->name == 'em produção')
                    <form action="{{ route('order-comission') }}" method="POST">
                        @csrf
                            <input type="text" name="name" placeholder="Titulo" value="{{ old('name') }}"   class=" @error('name') fild_error @enderror">
                            @error('name')
                            <p>{{ $message }} </p>    
                            @enderror            
                            <input type="text" name="description" placeholder="Entrega" value="{{ old('description') }}"  class=" @error('description') fild_error @enderror">
                            @error('description')
                            <p>{{ $message }} </p>    
                            @enderror
                            <p>Se precisar enviar algum arquivo, coloqueo no Google drive ou em algum serviço parecido e envie o link </p>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <x-button linkto='order-comission'>Enviar entrega</x-button>
                    </form>
                @elseif ($order->Status->name == 'negado')
                    Você negou este pedido 
                @elseif ($order->Status->name == 'entregue')
                    Pedido entregue :D
                @endif
            @else
            {{-- Pedidos a receber --}}
                @if ($order->Status->name == 'em analise')
                    Seu pedido esta sendo analisado por <a href="/profile/{{  $order->Service->User->id }}"> {{ $order->Service->User->name }} </a>
                @elseif ($order->Status->name == 'em produção')
                    Seu pedido esta sendo produzido carinhosamente por <a href="/profile/{{  $order->Service->User->id }}"> {{ $order->Service->User->name }} </a>
                @elseif ($order->Status->name == 'negado')
                    Infelizmente seu pedido foi negado por <a href="/profile/{{  $order->Service->User->id }}"> {{ $order->Service->User->name }} </a> 
                @elseif ($order->Status->name == 'entregue')    
                    {{ $order->Comission->first()->name }}
                    {{ $order->Comission->first()->description }}
                @endif
            @endif 
        </div>
    </x-modal>
</div>
@endforeach

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
