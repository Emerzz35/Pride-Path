@extends('layouts.app')

@section('content')
<img src="/img/profile/{{ auth()->user()->image }}">

<p>{{ auth()->user()->name }}</p>
@endsection