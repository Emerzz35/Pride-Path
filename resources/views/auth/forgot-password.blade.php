@extends('layouts.app')

@section('content')
<main class='h-screen flex justify-center items-center'>
    <div class='flex flex-col justify-center items-center'>
        <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="" />
        
        <h1 class="text-xl font-bold text-titulo mt-5">Recuperar Senha</h1>
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-xl mt-4">
                {{ session('success') }}
            </div>
        @endif
        
        <p class="text-destaque mt-4 text-center max-w-md px-4">
            Informe seu e-mail cadastrado e enviaremos um link para você redefinir sua senha.
        </p>
        
        <form action="{{ route('password.email') }}" method="POST" class='flex flex-col justify-center items-center mt-4'>
            @csrf
            
            <input 
                type="email" 
                name="email" 
                placeholder="Email" 
                value="{{ old('email') }}"
                class='bg-input rounded-xl px-4 py-2 mt-2 w-64'
                required
            >
            
            @error('email')
                <span class="text-red-700 mt-1 text-sm">{{ $message }}</span>    
            @enderror
            
            <x-button 
                class='w-full mt-5 bg-botao text-white px-4 py-2 rounded-xl hover:bg-opacity-90 transition-colors duration-200'
                linkto='password.email'
            >
                Enviar link de recuperação
            </x-button>
            
            <a href="{{ route('login') }}" class="text-link mt-4 hover:underline">
                Voltar para o login
            </a>
        </form>
    </div>
</main>
@endsection
