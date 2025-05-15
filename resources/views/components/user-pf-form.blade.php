<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-titulo mb-1">Nome completo</label>
        <input 
            type="text" 
            name="name" 
            id="name" 
            placeholder="Digite seu nome completo" 
            value="{{ old('name', Auth::user()->name) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="cpf" class="block text-sm font-medium text-titulo mb-1">CPF</label>
        <input 
            type="text" 
            name="cpf" 
            id="cpf" 
            placeholder="000.000.000-00" 
            value="{{ old('cpf', Auth::user()->cpf) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('cpf')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="phone" class="block text-sm font-medium text-titulo mb-1">Telefone</label>
        <input 
            type="text" 
            name="phone" 
            id="phone" 
            placeholder="(00) 00000-0000" 
            value="{{ old('phone', Auth::user()->phone) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="day_of_birth" class="block text-sm font-medium text-titulo mb-1">Data de nascimento</label>
        <input 
            type="text" 
            name="day_of_birth" 
            id="day_of_birth" 
            placeholder="DD/MM/AAAA" 
            value="{{ old('day_of_birth', Auth::user()->day_of_birth) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('day_of_birth')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="email" class="block text-sm font-medium text-titulo mb-1">Email</label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            placeholder="seu@email.com" 
            value="{{ old('email', Auth::user()->email) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div class="relative">
        <label for="password" class="block text-sm font-medium text-titulo mb-1">
            {{ Auth::check() ? 'Nova senha (opcional)' : 'Senha' }}
        </label>
        <div class="relative">
            <input 
                type="password" 
                name="password" 
                id="password" 
                placeholder="{{ Auth::check() ? 'Digite para alterar sua senha atual' : 'Digite sua senha' }}" 
                class="w-full bg-input rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-destaque"
                {{ Auth::check() ? '' : 'required' }}
            >
            <button 
                type="button" 
                class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 focus:outline-none" 
                data-target="password"
            >
                <svg class="h-5 w-5 eye-closed" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
                <svg class="h-5 w-5 eye-open hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
        @if(Auth::check())
            <p class="text-sm text-gray-500 mt-1">Deixe em branco para manter sua senha atual</p>
        @endif
    </div>
    
    <div class="relative">
        <label for="password_confirmation" class="block text-sm font-medium text-titulo mb-1">
            {{ Auth::check() ? 'Confirmar nova senha' : 'Confirmar senha' }}
        </label>
        <div class="relative">
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                placeholder="{{ Auth::check() ? 'Confirme sua nova senha' : 'Confirme sua senha' }}" 
                class="w-full bg-input rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-destaque"
                {{ Auth::check() ? '' : 'required' }}
            >
            <button 
                type="button" 
                class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 focus:outline-none" 
                data-target="password_confirmation"
            >
                <svg class="h-5 w-5 eye-closed" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
                <svg class="h-5 w-5 eye-open hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
        @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
</div>
