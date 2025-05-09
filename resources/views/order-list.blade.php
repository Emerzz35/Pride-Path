@extends('layouts.app')

@section('content')

@foreach ($orders as $order)
    {{ $order->name }}
    {{ $order->Status->name }}
    

    {{ $order->Service->name }}
    <img src="/{{ $order->Service->ServiceImage->first()->url }}" alt="{{ $order->Service->name }}">
    @if ($order->Service->User->id == Auth()->user()->id)
    <a href="/profile/{{  $order->user_id }}"> {{ $order->User->name }} </a>
    @else
        <a href="/profile/{{  $order->Service->User->id }}"> {{ $order->Service->User->name }} </a>
    @endif
    
@endforeach

@endsection
