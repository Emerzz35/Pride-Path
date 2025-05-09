@extends('layouts.app')


@if ($Service->activated == 1 or $Service->user->id === Auth()->user()->id)
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







    @if ( $Service->user->id === Auth()->user()->id)
    <x-button class='' id='editar-servico'>Editar Serviço</x-button>
    <x-modal>
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-gray-900">Editar Serviço</h1>
            <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal"/>
        </div>

        <div>
            <form action="{{ route('service-update', $Service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="text" name="name" placeholder="Titulo" value="{{ $Service->name }}"   class=" @error('name') fild_error @enderror">
                @error('name')
                <p>{{ $message }} </p>    
                @enderror
        
                <input type="text" name="description" placeholder="Descrição" value="{{ $Service->description }}"  class=" @error('description') fild_error @enderror">
                @error('description')
                <p>{{ $message }} </p>    
                @enderror
        
                <input type="text" id="price" name="price" placeholder="Preço" value="{{ $Service->price}}" class="@error('price') fild_error @enderror">
                @error('price')
                <p>{{ $message }}</p>    
                @enderror
        
                <div>
                    <label class="block text-sm font-medium">Categorias</label>
                    <div class="mt-2 space-y-1">
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    {{ in_array($category->id, $serviceCategories) ? 'checked' : '' }} class="mr-2">
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                
                @error('categories')
                <p>{{ $message }}</p>    
                @enderror
        
                <input type="file" name="images[]" multiple accept=".jpeg,.png,.jpg">
                @error('images')
                <p>{{ $message }}</p>    
                @enderror
                <label class="flex items-center">
                <input type="checkbox" name="activated" value="1" class="mr-2"  {{ !$Service->activated ? 'checked' : '' }}>
                desativar serviço?
                </label>

                <a href="{{ route('service-update', $Service->id) }}">
                    <button>
                        Atualizar serviço
                    </button>
                </a>
            </form>
        </div>
    </x-modal>
    @endif

    @endsection
@endif

@push('scripts')
    <script>
        const editarServico = document.getElementById('editar-servico')
        const boxModal = document.getElementById('box-modal') 
        const closeModal = document.getElementById('close-modal') 
         
        editarServico.addEventListener('click',()=>{
            event.preventDefault();
            boxModal.classList.remove('hidden')
            boxModal.classList.add('flex')   
        })

        closeModal.addEventListener('click',()=>{
            boxModal.classList.remove('flex')
            boxModal.classList.add('hidden')   
        })
        
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price');
        
            priceInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');  
                value = (value / 100).toFixed(2) + '';         
        
                value = value.replace('.', ',');               
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
        
                e.target.value = 'R$ ' + value;
            });
        });
        </script>
@endpush