@extends('layouts.app')

@section('content')
{{-- Fazer a pagina aqui --}}
<main>
    <form action="{{ route('user-insert') }}" method="POST">
        @csrf    
        <input type="text" name="name" placeholder="Seu nome">   
        <input type="text" name="email" placeholder="Seu Email">  
        <input type="password" name="password" placeholder="Sua senha">
        <span>Já tem uma conta? ><a href="#">Entrar</a></span>
        <x-button class='' linkto='user-insert'>Criar nova conta</x-button>
    </form>
</main>
@endsection