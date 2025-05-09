<a href="{{ !empty($linkto) ? route($linkto) : '' }}" id="{{ $id ?? '' }}">
    <button class={{ $class ?? '' }}>
        {{ $slot }}
    </button>
</a>