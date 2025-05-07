@extends('layouts.app')

@section('content')
<main>
    {{-- Botões para trocar entre PF e PJ --}}
    <div>
        <a href="{{ route('user-create', ['tipo' => 'pf']) }}">
            <button type="button" {{ $tipo === 'pf' ? '' : '' }}>Pessoa Física</button>
        </a>
        <a href="{{ route('user-create', ['tipo' => 'pj']) }}">
            <button type="button" {{ $tipo === 'pj' ? '' : '' }}>Pessoa Jurídica</button>
        </a>
    </div>
    <form action="{{ route('user-insert') }}" method="POST">
        @csrf

        {{-- Formulário dinâmico --}}
        @if ($tipo === 'pj')
            @include('components.user-pj-form')
        @else
            @include('components.user-pf-form')
        @endif
        {{-- Endereço --}}
        @include('components.address-form')

        <input type="hidden" name="user_type" value="{{ $tipo }}">
        <span>Já tem uma conta? <a href="{{ route('login') }}">Entrar</a></span>
        <x-button linkto='user-insert'>Criar nova conta</x-button>
    </form>
</main>
@endsection
