<div id="{{ $id }}" class="hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full max-h-[90vh] overflow-hidden">
        <div class="p-5">
            {{ $slot }}
        </div>
    </div>
</div>
