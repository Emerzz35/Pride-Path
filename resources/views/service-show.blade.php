@extends('layouts.app')

@auth
    
@if ($Service->activated == 1 or $Service->user->id === Auth()->user()->id)
    @section('content')
    {{ $Service->name }}
    {{ $Service->description }}
    {{ $Service->price}}

    @foreach ($Service->ServiceImage as $Image)
    <img src="/{{ $Image->url }}">  
    @endforeach


     {{ $Service->averageRating(); }}
    @php
        $rating = $Service->averageRating(); // Ex: 3.5
        $fullStars = floor($rating);         // Ex: 3
        $halfStar = ($rating - $fullStars) >= 0.25 && ($rating - $fullStars) < 0.75; // Mostrar meia estrela
        $almostFull = ($rating - $fullStars) >= 0.75; // Mostrar estrela quase cheia
        $emptyStars = 5 - $fullStars - ($halfStar || $almostFull ? 1 : 0);
    @endphp

    <div class="flex items-center text-yellow-500">
        {{-- Estrelas inteiras --}}
        @for ($i = 0; $i < $fullStars; $i++)
            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
        @endfor

        {{-- Estrela quase cheia (maior que 0.75) --}}
        @if($almostFull)
            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><defs><linearGradient id="star90"><stop offset="90%" stop-color="currentColor"/><stop offset="90%" stop-color="transparent"/></linearGradient></defs><path fill="url(#star90)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
        @elseif($halfStar)
            {{-- Meia estrela --}}
            <svg class="w-5 h-5" viewBox="0 0 20 20">
                <defs>
                    <linearGradient id="halfGrad">
                        <stop offset="50%" stop-color="currentColor" />
                        <stop offset="50%" stop-color="transparent" />
                    </linearGradient>
                </defs>
                <path fill="url(#halfGrad)" d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z" />
            </svg>
        @endif

        {{-- Estrelas vazias --}}
        @for ($i = 0; $i < $emptyStars; $i++)
            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.562-.955L10 0l2.95 5.955 6.562.955-4.756 4.635 1.122 6.545z"/></svg>
        @endfor
    </div>




    @foreach ($Service->categories as $category)
    {{$category->name}}
    @endforeach


    <a href="/profile/{{  $Service->user_id }}}">{{ $Service->user->name }}</a>

    

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
    @else
        <x-button class='' id='editar-servico'>Fazer pedido</x-button>
        <x-modal>
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Fazer pedido</h1>
                <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal"/>
            </div>

            <div>
                <form action="{{ route('order-store') }}" method="POST">
                    @csrf

                    <input type="text" name="name" placeholder="Titulo" value="{{ old('name') }}"   class=" @error('name') fild_error @enderror">
                    @error('name')
                    <p>{{ $message }} </p>    
                    @enderror
            
                    <input type="text" name="description" placeholder="Descrição" value="{{ old('description') }}"  class=" @error('description') fild_error @enderror">
                    @error('description')
                    <p>{{ $message }} </p>    
                    @enderror

                    <input type="hidden" name="service_id" value="{{ $Service->id }}">
            
                    <x-button linkto='order-store'>Fazer pedido</x-button>
                </form>
            </div>
        </x-modal> 

        @if (! $ratingExists)
        <form id="rating-form" action="{{ route('service-rate', $Service->id) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="rating" id="rating-value">

            <div id="star-rating" class="flex space-x-2 text-3xl text-gray-300 cursor-pointer">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star transition-colors" data-value="{{ $i }}">&#9733;</span>
                @endfor
            </div>

            <p id="rating-text" class="text-sm text-gray-500"></p>

            <textarea name="comment" class="w-full p-2 border rounded-lg" placeholder="Comentário (opcional)" maxlength="500"></textarea>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                Enviar Avaliação
            </button>
        </form>
        @endif

        <x-button class='' id='reportar-servico'>Reportar serviço</x-button>
        <x-modal id="report-modal">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Reportar serviço</h1>
                <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal-report"/>
            </div>

            <div>
                <form action="{{ route('report-store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="service">
                    <input type="hidden" name="id" value="{{ $Service->id }}">
                    <textarea name="reason" placeholder="Descreva o motivo" required></textarea>
                    <button type="submit" class="btn btn-warning">Reportar</button>
                </form>
            </div>
        </x-modal>

        

    @endif

    @if (Auth::id() === $Service->user_id || Auth::user()->isAdmin())
        <form action="{{ route('service-destroy', $Service->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Excluir Serviço</button>
        </form>
    @endif


    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Avaliações</h2>

        @forelse ($ratings as $rating)
            <div class="mb-6 border-b pb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="/img/profile/{{$rating->user->image }}" >
                        <span class="font-semibold">{{ $rating->user->name }}</span>
                        <span class="text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.2 3.674a1 1 0 00.95.69h3.862c.969 0 1.371 1.24.588 1.81l-3.125 2.27a1 1 0 00-.364 1.118l1.2 3.674c.3.921-.755 1.688-1.538 1.118l-3.125-2.27a1 1 0 00-1.176 0l-3.125 2.27c-.783.57-1.838-.197-1.538-1.118l1.2-3.674a1 1 0 00-.364-1.118L2.45 9.1c-.783-.57-.38-1.81.588-1.81h3.862a1 1 0 00.95-.69l1.2-3.674z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                @if($rating->comment)
                    <p class="mt-2 text-gray-700">{{ $rating->comment }}</p>
                @endif
                @if ($rating->user_id === Auth::id())

                    <form action="{{ route('rating-destroy', ['serviceId' => $Service->id]) }}" method="POST" onsubmit="return confirm('Deseja excluir sua avaliação?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir Minha Avaliação</button>
                    </form>
                @else
                {{-- Reportar avaliação --}}

                <x-button class='' id='reportar-rating'>Reportar Avaliação</x-button>
                    <x-modal id="report-rating-modal">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-xl font-semibold text-gray-900">Reportar Avaliação</h1>
                            <x-jam-close class="cursor-pointer text-gray-500 hover:text-gray-700"  id="close-modal-report-rating"/>
                        </div>

                        <div>
                            <form action="{{ route('report-store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="rating">
                                <input type="hidden" name="id" value="{{ $rating->id }}">
                                <textarea name="reason" placeholder="Descreva o motivo" required></textarea>
                                <button type="submit" class="btn btn-warning">Reportar Avaliação</button>
                            </form>
                        </div>
                    </x-modal>
                

                @endif

                @if (Auth::user()->isAdmin())
                    
                    <form action="{{ route('rating-destroy', ['serviceId' => $rating->service_id, 'userId' => $rating->user_id]) }}" method="POST" onsubmit="return confirm('Deseja excluir esta avaliação?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir Avaliação</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Ainda não há avaliações para este produto.</p>
        @endforelse
    </div>

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
        const reportarServico = document.getElementById('reportar-servico')
        const reportModal = document.getElementById('report-modal') 
        const closeModalReport = document.getElementById('close-modal-report') 
         
        reportarServico.addEventListener('click',()=>{
            event.preventDefault();
            reportModal.classList.remove('hidden')
            reportModal.classList.add('flex')   
        })

        closeModalReport.addEventListener('click',()=>{
            reportModal.classList.remove('flex')
            reportModal.classList.add('hidden')   
        })
        
    </script>
    <script>
        const reportarRating = document.getElementById('reportar-rating')
        const reportModalRating = document.getElementById('report-rating-modal') 
        const closeModalReportRating = document.getElementById('close-modal-report-rating') 
         
        reportarRating.addEventListener('click',()=>{
            event.preventDefault();
            reportModalRating.classList.remove('hidden')
            reportModalRating.classList.add('flex')   
        })

        closeModalReportRating.addEventListener('click',()=>{
            reportModalRating.classList.remove('flex')
            reportModalRating.classList.add('hidden')   
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

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating-value');
        const ratingText = document.getElementById('rating-text');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const val = parseInt(star.dataset.value);
                highlightStars(val);
                ratingText.innerText = textMap[val];
            });

            star.addEventListener('click', () => {
                selectedRating = parseInt(star.dataset.value);
                ratingInput.value = selectedRating;
                highlightStars(selectedRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                const val = parseInt(star.dataset.value);
                star.classList.toggle('text-yellow-400', val <= rating);
                star.classList.toggle('text-gray-300', val > rating);
            });
        }
    </script>
@endpush