@extends('layouts.app')

@section('content')
{{-- Fazer a pagina aqui --}}
<main>
    <form action="{{ route('user-create') }}" method="POST">
        @csrf    
        <input type="text" name="name" placeholder="Seu nome" value="{{ old('name') }}" class=" @error('name') fild_error @enderror">   
        {{-- A classe "fild_error" é adicionada quando o usuario não preenche o campo corretamente, usa ela pra estilizar --}}
        @error('name')
            <p>{{ $message }} </p>    
        @enderror
        <input type="text" name="email" placeholder="Seu Email" value="{{ old('email')}}" class=" @error('email') fild_error @enderror"> 
        @error('email')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="password" name="password" placeholder="Sua senha" class=" @error('password') fild_error @enderror">
        @error('password')
            <p>{{ $message }} </p>    
        @enderror
        <span>Já tem uma conta?<a href="{{ route('user-login') }}">Entrar</a></span>
        <x-button class='' linkto='user-insert'>Criar nova conta</x-button>
    </form>
</main>
@endsection