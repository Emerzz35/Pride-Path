@extends('layouts.app')

@section('content')
{{ $Service->name }}
{{ $Service->description }}
{{ $Service->price}}

@foreach ($Service->ServiceImage as $Image)
<img src="/{{ $Image->url }}">  
@endforeach

@foreach ($Service->categories as $category)
{{$category->name}}
@endforeach

{{ $Service->user->name }}
@endsection