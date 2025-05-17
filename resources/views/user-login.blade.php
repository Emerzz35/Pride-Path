@extends('layouts.app')

@section('content')
{{-- Fazer a pagina aqui --}}
<main class='h-screen flex justify-center items-center'>
    <form action="{{ route('auth') }}" method="POST" class='flex flex-col justify-center items-center'>
        @csrf  
        <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="" />
        <span class='text-titulo mt-5'>Não tem uma conta?<a class='text-link' href="{{ route('user-create') }}">Registre-se</a></span>  
        <input class='bg-input rounded-xl px-4 py-2 mt-5' type="text" name="email" placeholder="Email" value="{{ old('email') }}">  
        <input class='bg-input rounded-xl px-4 py-2 mt-5' type="password" name="password" placeholder="Senha">  
        <span class='mt-5 text-link'><a href="{{ route('password.request') }}">Esqueceu a senha?</a></span>    
        <x-button class='w-full mt-5 bg-botao text-white px-4 py-2 rounded-xl hover:bg-opacity-90 transition-colors duration-200' linkto='auth'>Entrar</x-button>

        @if (session('status'))
        <span class="text-red-700">{{ session('status') }}</span>
        @endif
        
        @if (session('success'))
        <span class="text-green-600 mt-2">{{ session('success') }}</span>
        @endif
    </form>
</main>
@endsection
