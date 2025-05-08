@extends('layouts.app')

@section('content')
<main>
    <form action="{{ route('service-store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Titulo" value="{{ old('name') }}"   class=" @error('name') fild_error @enderror">
        @error('name')
        <p>{{ $message }} </p>    
        @enderror

        <input type="text" name="description" placeholder="Descrição" value="{{ old('description') }}"  class=" @error('description') fild_error @enderror">
        @error('description')
        <p>{{ $message }} </p>    
        @enderror

        <input type="text" id="price" name="price" placeholder="Preço" value="{{ old('price') }}" class="@error('price') fild_error @enderror">
        @error('price')
        <p>{{ $message }}</p>    
        @enderror

        <div>
            <label class="block text-sm font-medium">Categorias</label>
            <div class="mt-2 space-y-1">
                @foreach ($categories as $category)
                    <label class="flex items-center">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="mr-2">
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
       
        <x-button linkto='service-store'>Publicar</x-button>
    </form>
</main>



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
@endsection
