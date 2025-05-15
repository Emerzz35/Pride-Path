<div class="space-y-4">
    <div>
        <label for="corporate_reason" class="block text-sm font-medium text-titulo mb-1">Razão Social</label>
        <input 
            type="text" 
            name="corporate_reason" 
            id="corporate_reason" 
            placeholder="Digite a razão social" 
            value="{{ old('corporate_reason', Auth::user()->corporate_reason) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('corporate_reason')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="cnpj" class="block text-sm font-medium text-titulo mb-1">CNPJ</label>
        <input 
            type="text" 
            name="cnpj" 
            id="cnpj" 
            placeholder="00.000.000/0000-00" 
            value="{{ old('cnpj', Auth::user()->cnpj) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('cnpj')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="state_registration" class="block text-sm font-medium text-titulo mb-1">Inscrição Estadual</label>
        <input 
            type="text" 
            name="state_registration" 
            id="state_registration" 
            placeholder="Digite a inscrição estadual" 
            value="{{ old('state_registration', Auth::user()->state_registration) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('state_registration')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
        @enderror
    </div>
    
    <div>
        <label for="responsable" class="block text-sm font-medium text-titulo mb-1">Nome do responsável</label>
        <input 
            type="text" 
            name="responsable" 
            id="responsable" 
            placeholder="Digite o nome do responsável" 
            value="{{ old('responsable', Auth::user()->responsable) }}"
            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
            required
        >
        @error('responsable')
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
