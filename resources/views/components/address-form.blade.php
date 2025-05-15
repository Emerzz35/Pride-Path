<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="cep" class="block text-sm font-medium text-titulo mb-1">CEP</label>
            <input 
                type="text" 
                name="cep" 
                id="cep" 
                placeholder="00000-000" 
                value="{{ old('cep', Auth::user()->cep) }}"
                class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                required
            >
            @error('cep')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
            @enderror
        </div>
        <div>
            <label for="state_id" class="block text-sm font-medium text-titulo mb-1">Estado</label>
            <select 
                name="state_id" 
                id="state_id" 
                class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque appearance-none"
                required
            >
                <option value="">Selecione um estado</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ (Auth::check() && Auth::user()->state_id == $state->id) || old('state_id') == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
            @error('state_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
            @enderror
        </div>
    </div>
    
    <div>
        <label for="address_city" class="block text-sm font-medium text-titulo mb-1">Cidade</label>
        <input 
            type="text" 
            name="address_city" 
            id="address_city" 
            placeholder="Digite sua cidade" 
            value="{{ old('address_city', Auth::user()->address_city) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('address_city')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="neighborhood" class="block text-sm font-medium text-titulo mb-1">Bairro</label>
        <input 
            type="text" 
            name="neighborhood" 
            id="neighborhood" 
            placeholder="Digite seu bairro" 
            value="{{ old('neighborhood', Auth::user()->neighborhood) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('neighborhood')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="address_street" class="block text-sm font-medium text-titulo mb-1">Rua</label>
        <input 
            type="text" 
            name="address_street" 
            id="address_street" 
            placeholder="Digite sua rua" 
            value="{{ old('address_street', Auth::user()->address_street) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('address_street')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="address_number" class="block text-sm font-medium text-titulo mb-1">Número</label>
            <input 
                type="text" 
                name="address_number" 
                id="address_number" 
                placeholder="Nº" 
                value="{{ old('address_number', Auth::user()->address_number) }}"
                class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                required
            >
            @error('address_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
            @enderror
        </div>
        <div>
            <label for="address_complement" class="block text-sm font-medium text-titulo mb-1">Complemento</label>
            <input 
                type="text" 
                name="address_complement" 
                id="address_complement" 
                placeholder="Apto, bloco, etc." 
                value="{{ old('address_complement', Auth::user()->address_complement) }}"
                class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            >
            @error('address_complement')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
            @enderror
        </div>
    </div>
</div>
