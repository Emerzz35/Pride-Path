@extends('layouts.app')

@section('content')
{{-- Fazer a pagina aqui --}}
<main class='h-screen flex justify-center items-center'>
    <form action="{{ route('login') }}" method="POST" class='flex flex-col justify-center items-center'>
        @csrf  
        <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="" />
        <span class='text-titulo mt-5'>Não tem uma conta?<a class='text-link' href="{{ route('user-insert') }}">Registre-se</a></span>  
        <input class='bg-input rounded-xl px-4 py-2 mt-5'  type="text" name="email" placeholder="Email">  
        <input class='bg-input rounded-xl px-4 py-2 mt-5' type="password" name="password" placeholder="Senha">  
        <span class='mt-5 text-red-700'><a href="#">Esqueceu a senha?</a></span>    
        <x-confirm-button class='w-full mt-5' linkto='login'>Entrar</x-button>

        @if (session('status'))
        <span class="txt_error">{{ session('status') }} </span>
        @endif
    </form>
</main>
@endsection