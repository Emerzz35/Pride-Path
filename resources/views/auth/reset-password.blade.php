@extends('layouts.app')

@section('content')
<main class='h-screen flex justify-center items-center'>
    <div class='flex flex-col justify-center items-center'>
        <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="" />
        
        <h1 class="text-xl font-bold text-titulo mt-5">Redefinir Senha</h1>
        
        <form action="{{ route('password.update') }}" method="POST" class='flex flex-col justify-center items-center mt-4'>
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            
            <input 
                type="email" 
                name="email" 
                placeholder="Email" 
                value="{{ $email ?? old('email') }}"
                class='bg-input rounded-xl px-4 py-2 mt-2 w-64'
                required
                readonly
            >
            
            @error('email')
                <span class="text-red-700 mt-1 text-sm">{{ $message }}</span>    
            @enderror
            
            <input 
                type="password" 
                name="password" 
                id="password" 
                placeholder="Nova senha" 
                class='bg-input rounded-xl px-4 py-2 mt-4 w-64'
                required
            >
            
            @error('password')
                <span class="text-red-700 mt-1 text-sm">{{ $message }}</span>    
            @enderror
            
            <input 
                type="password" 
                name="password_confirmation" 
                placeholder="Confirmar nova senha" 
                class='bg-input rounded-xl px-4 py-2 mt-2 w-64'
                required
            >
            
            <x-button 
                class='w-full mt-5 bg-botao text-white px-4 py-2 rounded-xl hover:bg-opacity-90 transition-colors duration-200'
                linkto='password.update'
            >
                Redefinir senha
            </x-button>
            
            <a href="{{ route('login') }}" class="text-link mt-4 hover:underline">
                Voltar para o login
            </a>
        </form>
    </div>
</main>
@endsection
