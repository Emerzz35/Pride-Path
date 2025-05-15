@extends('layouts.app')

@section('content')
<main class="min-h-screen flex justify-center items-center py-10 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
        <div class="flex justify-center mb-6">
            <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="h-16" />
        </div>
        
        {{-- Botões para trocar entre PF e PJ --}}
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('user-create', ['tipo' => 'pf']) }}" class="w-1/2">
                <button type="button" 
                    class="w-full py-3 px-4 rounded-xl transition-colors duration-200 {{ $tipo === 'pf' ? 'bg-titulo text-white' : 'bg-input text-gray-700 hover:bg-gray-200' }}">
                    Pessoa Física
                </button>
            </a>
            <a href="{{ route('user-create', ['tipo' => 'pj']) }}" class="w-1/2">
                <button type="button" 
                    class="w-full py-3 px-4 rounded-xl transition-colors duration-200 {{ $tipo === 'pj' ? 'bg-titulo text-white' : 'bg-input text-gray-700 hover:bg-gray-200' }}">
                    Pessoa Jurídica
                </button>
            </a>
        </div>
        
        <form action="{{ route('user-insert') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Formulário dinâmico --}}
            <div class="space-y-4">
                @if ($tipo === 'pj')
                    @include('components.user-pj-form')
                @else
                    @include('components.user-pf-form')
                @endif
            </div>
            
            {{-- Endereço --}}
            <div class="pt-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Endereço</h3>
                @include('components.address-form')
            </div>

            <input type="hidden" name="user_type" value="{{ $tipo }}">
            
            <div class="flex flex-col items-center space-y-4 pt-4">
                <span class="text-titulo">
                    Já tem uma conta? 
                    <a href="{{ route('login') }}" class="text-link">Entrar</a>
                </span>
                
                <x-confirm-button 
                    class="w-full py-3 transition-colors duration-200" 
                    linkto='user-insert'>
                    Criar nova conta
                </x-confirm-button>
                
                @if (session('status'))
                <span class="text-red-700">{{ session('status') }}</span>
                @endif
            </div>
        </form>
    </div>
</main>
@endsection
