@extends('layouts.app')

@section('content')
<main>
    

    <form action="{{ route('user-update') }}" method="POST">
        @csrf
        @method('patch')

        {{-- Formulário dinâmico --}}
        @if ($tipo === 'pj')
            @include('components.user-pj-form')
        @else
            @include('components.user-pf-form')
        @endif

        {{-- Endereço --}}
        @include('components.address-form')

        <input type="hidden" name="user_type" value="{{ $tipo }}">
        <x-button linkto='user-update'>Salvar novos dados</x-button>
    </form>
</main>
@endsection
