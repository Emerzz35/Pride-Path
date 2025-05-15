<a  class='w-full' href="{{ !empty($linkto) ? route($linkto) : '' }}" id="{{ $id ?? '' }}">
    <button class=" bg-botao hover:bg-blue-950 text-white font-bold py-2 px-4 border-b-4 border-blue-900 hover:border-blue-800 rounded-xl {{ $class ?? '' }}">
        {{ $slot }}
    </button>
</a>
