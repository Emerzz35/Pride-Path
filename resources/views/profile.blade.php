@extends('layouts.app')

@section('content')
<img src="/img/profile/{{ $User->image }}" @if ($User->id === Auth()->user()->id) id='profile-picture'  @endif >

<p>{{ $User->name }}</p>

@if ($User->id === Auth()->user()->id) 
<x-button linkto='user-edit'>Editar perfil</x-button>
<x-button linkto='order-list'>Meus pedidos</x-button>
<x-button linkto='order-received'>Minhas entregas</x-button>
<x-button class='' linkto='service-create'>Postar serviço</x-button>
@endif

@if (Auth::id() === $User->id || Auth::user()->isAdmin())
    <form action="{{ route('user-destroy', $User->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="">Excluir</button>
    </form>
@endif



{{-- Servicos --}}


@foreach ($User->Service as  $service)
    @if ($service->activated == true or $User->id === Auth()->user()->id) 
        

        <a href="{{ route('service-show', $service->id) }}">
            <img src="/{{ $service->ServiceImage->first()->url }}">  
            {{$service->name}}
            {{$service->description }}
            {{$service->price}}
        </a>
    @endif
@endforeach


@if ($User->id === Auth()->user()->id) 
<x-modal>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Selecione uma foto de perfil</h1>
        <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal"/>
    </div>

    <div>
        <form method="POST" action="{{ route('user-updateImage') }}" accept=".jpeg,.png,.jpg" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('patch')
            <input
                type="file"
                id="image"
                name="image"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100
                "
            />
            <x-button linkto='user-updateImage' class="w-full justify-center">Atualizar foto de perfil</x-button>
        </form>
    </div>
</x-modal>
@endif

@endsection

@push('scripts')
    <script>
        const profilePicture = document.getElementById('profile-picture')
        const boxModal = document.getElementById('box-modal') 
        const closeModal = document.getElementById('close-modal') 
         
        profilePicture.addEventListener('click',()=>{
            boxModal.classList.remove('hidden')
            boxModal.classList.add('flex')   
        })

        closeModal.addEventListener('click',()=>{
            boxModal.classList.remove('flex')
            boxModal.classList.add('hidden')   
        })
        @if(session('show_modal'))
        
        window.addEventListener('DOMContentLoaded', () => {
            boxModal.classList.remove('hidden')
            boxModal.classList.add('flex')   
        })
        @endif
        
    </script>
@endpush