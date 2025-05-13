@extends('layouts.app')

@section('content')
<img src="/img/profile/{{ $User->image }}" @if ($User->id === Auth()->user()->id) id='profile-picture'  @endif >

<p>{{ $User->name }}</p>
<div class="mb-6">
    <h2 class="text-lg font-bold">Média Geral das Avaliações</h2>

    @if ($overallAverage)
        @php
            $fullStars = floor($overallAverage);
            $decimal = $overallAverage - $fullStars;
            $halfStar = $decimal >= 0.25 && $decimal < 0.75;
            $almostFull = $decimal >= 0.75;
            $emptyStars = 5 - $fullStars - ($halfStar || $almostFull ? 1 : 0);
        @endphp

        <div class="flex items-center mt-2 text-yellow-400">
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

            <span class="ml-2 text-gray-700">{{ number_format($overallAverage, 1) }}/5</span>
        </div>
    @else
        <p class="text-gray-500">Este usuário ainda não possui avaliações em seus serviços.</p>
    @endif
</div>



@if ($User->id === Auth()->user()->id) 
<x-button linkto='user-edit'>Editar perfil</x-button>
<x-button linkto='order-list'>Meus pedidos</x-button>
<x-button linkto='order-received'>Minhas entregas</x-button>
<x-button class='' linkto='service-create'>Postar serviço</x-button>
@else
  <x-button class='' id='reportar-servico'>Reportar perfil</x-button>
    <x-modal id="report-modal">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Reportar {{ $User->name }}</h1>
                <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal-report"/>
            </div>

            <div>
                <form action="{{ route('report-store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="user">
                    <input type="hidden" name="id" value="{{ $User->id }}">
                    <textarea name="reason" placeholder="Descreva o motivo" required></textarea>
                    <button type="submit" class="btn btn-warning">Reportar</button>
                </form>
            </div>
     </x-modal>
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
        <form method="POST" action="{{ route('user-updateImage') }}"  enctype="multipart/form-data" class="space-y-4">
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
                       hover:file:bg-blue-100"
                accept=".jpeg,.png,.jpg"
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
     <script>
        const reportarServico = document.getElementById('reportar-servico')
        const reportModal = document.getElementById('report-modal') 
        const closeModalReport = document.getElementById('close-modal-report') 
         
        reportarServico.addEventListener('click',()=>{
            event.preventDefault();
            reportModal.classList.remove('hidden')
            reportModal.classList.add('flex')   
        })

        closeModalReport.addEventListener('click',()=>{
            reportModal.classList.remove('flex')
            reportModal.classList.add('hidden')   
        })
        
    </script>
@endpush