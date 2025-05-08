@extends('layouts.app')

@section('content')

@foreach ($services as $service)

    <a href="{{ route('service-show', $service->id) }}">

        <img src="/{{ $service->ServiceImage->first()->url }}">  
        {{$service->name}}
        {{$service->description }}
        {{$service->price}}
    
    </a>

@endforeach

@endsection