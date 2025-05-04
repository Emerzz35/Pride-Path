<a href="{{route($linkto)}}" id="{{ $id ?? '' }}">
    <button class={{ $class ?? '' }}>
        {{ $slot }}
    </button>
</a>