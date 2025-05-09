@extends('layouts.app')

@section('content')

<form method="GET" action="{{ route('service-index') }}">
    <label for="search">Pesquisar:</label>
    <input type="text" name="search" id="search" value="{{ request('search') }}">

    <label for="category">Filtrar por categoria:</label>
    <select name="category" id="category">
        <option value="">Todas as categorias</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Buscar</button>
</form>

@foreach ($services as $service)
    @if ($service->activated == 1)
        <a href="{{ route('service-show', $service->id) }}">
            <img src="/{{ $service->ServiceImage->first()->url }}" alt="{{ $service->name }}">
            <div>{{ $service->name }}</div>
            <div>{{ $service->description }}</div>
            <div>R$ {{ number_format($service->price, 2, ',', '.') }}</div>
        </a>
    @endif
@endforeach

@endsection
