@extends('layouts.app')

@section('content')
<img src="/img/profile/{{ auth()->user()->image }}" id='profile-picture'>

<p>{{ auth()->user()->name }}</p>
<x-modal>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Selecione uma foto de perfil</h1>
        <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal"/>
    </div>

    <div>
        <form method="POST" action="{{ route('user-updateImage') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('patch')
            <input
                type="file"
                id="image"
                name="image"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100
                "
            />
            <x-button linkto='user-updateImage' class="w-full justify-center">Atualizar foto de perfil</x-button>
        </form>
    </div>
</x-modal>

@endsection

@push('scripts')
    <script>
        const profilePicture = document.getElementById('profile-picture')
        const boxModal = document.getElementById('box-modal') 
        const closeModal = document.getElementById('close-modal') 
         
        profilePicture.addEventListener('click',()=>{
            boxModal.classList.remove('hidden')
            boxModal.classList.add('flex')   
        })

        closeModal.addEventListener('click',()=>{
            boxModal.classList.remove('flex')
            boxModal.classList.add('hidden')   
        })

        
    </script>
@endpush