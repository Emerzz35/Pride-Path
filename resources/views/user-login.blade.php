@extends('layouts.app')

@section('content')
{{-- Fazer a pagina aqui --}}
<main>
    <form action="{{ route('login') }}" method="POST">
        @csrf  
        <span>Não tem uma conta?<a href="{{ route('user-insert') }}">Registre-se</a></span>  
        <input type="text" name="email" placeholder="Email">  
        <input type="password" name="password" placeholder="Senha">  
        <span><a href="#">Esqueceu a senha?</a></span>    
        <x-button class='' linkto='login'>Entrar</x-button>

        @if (session('status'))
        <span class="txt_error">{{ session('status') }} </span>
        @endif
    </form>
</main>
@endsection