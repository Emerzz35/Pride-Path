@extends('layouts.app')

@section('content')
<main class="min-h-screen flex justify-center items-center py-10 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
        <div class="flex justify-center mb-6">
            <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="h-16" />
        </div>
        
        {{-- Botões para trocar entre PF e PJ --}}
        <div class="flex justify-center space-x-4 mb-8">
            <button type="button" 
                id="btn-pf"
                class="w-1/2 py-3 px-4 rounded-xl transition-colors duration-200 bg-botao text-white">
                Pessoa Física
            </button>
            <button type="button" 
                id="btn-pj"
                class="w-1/2 py-3 px-4 rounded-xl transition-colors duration-200 bg-input text-gray-700 hover:bg-gray-200">
                Pessoa Jurídica
            </button>
        </div>
        
        <form action="{{ route('user-insert') }}" method="POST" class="space-y-6" id="registration-form">
            @csrf

            {{-- Formulário dinâmico --}}
            <div class="space-y-4">
                {{-- Formulário PF (visível por padrão) --}}
                <div id="form-pf">
                    <div>
                        <label for="name" class="block text-sm font-medium text-titulo mb-1">Nome completo</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            placeholder="Digite seu nome completo" 
                            value="{{ old('name') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="cpf" class="block text-sm font-medium text-titulo mb-1">CPF</label>
                        <input 
                            type="text" 
                            name="cpf" 
                            id="cpf" 
                            placeholder="000.000.000-00" 
                            value="{{ old('cpf') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                            required
                        >
                        @error('cpf')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="day_of_birth" class="block text-sm font-medium text-titulo mb-1">Data de nascimento</label>
                        <input 
                            type="text" 
                            name="day_of_birth" 
                            id="day_of_birth" 
                            placeholder="DD/MM/AAAA" 
                            value="{{ old('day_of_birth') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                            required
                        >
                        <input type="hidden" name="day_of_birth_formatted" id="day_of_birth_formatted">
                        @error('day_of_birth')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                </div>
                
                {{-- Formulário PJ (oculto por padrão) --}}
                <div id="form-pj" class="hidden">
                    <div>
                        <label for="corporate_reason" class="block text-sm font-medium text-titulo mb-1">Razão Social</label>
                        <input 
                            type="text" 
                            name="corporate_reason" 
                            id="corporate_reason" 
                            placeholder="Digite a razão social" 
                            value="{{ old('corporate_reason') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                        @error('corporate_reason')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="cnpj" class="block text-sm font-medium text-titulo mb-1">CNPJ</label>
                        <input 
                            type="text" 
                            name="cnpj" 
                            id="cnpj" 
                            placeholder="00.000.000/0000-00" 
                            value="{{ old('cnpj') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                        @error('cnpj')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="state_registration" class="block text-sm font-medium text-titulo mb-1">Inscrição Estadual</label>
                        <input 
                            type="text" 
                            name="state_registration" 
                            id="state_registration" 
                            placeholder="Digite a inscrição estadual" 
                            value="{{ old('state_registration') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                        @error('state_registration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="responsable" class="block text-sm font-medium text-titulo mb-1">Nome do responsável</label>
                        <input 
                            type="text" 
                            name="responsable" 
                            id="responsable" 
                            placeholder="Digite o nome do responsável" 
                            value="{{ old('responsable') }}"
                            class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        >
                        @error('responsable')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                        @enderror
                    </div>
                </div>
                
                {{-- Campos comuns para ambos os tipos --}}
                <div class="mt-4">
                    <label for="phone" class="block text-sm font-medium text-titulo mb-1">Telefone</label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        placeholder="(00) 00000-0000" 
                        value="{{ old('phone') }}"
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        required
                    >
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                    @enderror
                </div>
                
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-titulo mb-1">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="seu@email.com" 
                        value="{{ old('email') }}"
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                    @enderror
                </div>
                
                <div class="mt-4">
                    <label for="email_confirmation" class="block text-sm font-medium text-titulo mb-1">Confirmar Email</label>
                    <input 
                        type="email" 
                        name="email_confirmation" 
                        id="email_confirmation" 
                        placeholder="Confirme seu email" 
                        value="{{ old('email_confirmation') }}"
                        class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                        required
                    >
                    @error('email_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                    @enderror
                </div>
                
                <div class="mt-4 relative">
                    <label for="password" class="block text-sm font-medium text-titulo mb-1">Senha</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            placeholder="Digite sua senha" 
                            class="w-full bg-input rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-destaque"
                            required
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
                </div>
                
                <div class="mt-4 relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-titulo mb-1">Confirmar Senha</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            placeholder="Confirme sua senha" 
                            class="w-full bg-input rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-destaque"
                            required
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
            
            {{-- Endereço --}}
            <div class="pt-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Endereço</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cep" class="block text-sm font-medium text-titulo mb-1">CEP</label>
                            <input 
                                type="text" 
                                name="cep" 
                                id="cep" 
                                placeholder="00000-000" 
                                value="{{ old('cep') }}"
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
                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
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
                            value="{{ old('address_city') }}"
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
                            value="{{ old('neighborhood') }}"
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
                            value="{{ old('address_street') }}"
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
                                value="{{ old('address_number') }}"
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
                                value="{{ old('address_complement') }}"
                                class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque"
                            >
                            @error('address_complement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="user_type" id="user_type" value="pf">
            
            <div class="flex flex-col items-center space-y-4 pt-4">
                <span class="text-titulo">
                    Já tem uma conta? 
                    <a href="{{ route('login') }}" class="text-link">Entrar</a>
                </span>
                
                <x-button 
                    class="w-full py-3 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200" 
                    linkto='user-insert'>
                    Criar nova conta
                </x-button>
                
                @if (session('status'))
                <span class="text-red-700">{{ session('status') }}</span>
                @endif
            </div>
        </form>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Alternância entre formulários PF e PJ
        const btnPF = document.getElementById('btn-pf');
        const btnPJ = document.getElementById('btn-pj');
        const formPF = document.getElementById('form-pf');
        const formPJ = document.getElementById('form-pj');
        const userTypeInput = document.getElementById('user_type');
        
        // Função para alternar entre PF e PJ
        function toggleForms(isPF) {
            if (isPF) {
                formPF.classList.remove('hidden');
                formPJ.classList.add('hidden');
                btnPF.classList.add('bg-botao', 'text-white');
                btnPF.classList.remove('bg-input', 'text-gray-700');
                btnPJ.classList.remove('bg-botao', 'text-white');
                btnPJ.classList.add('bg-input', 'text-gray-700');
                userTypeInput.value = 'pf';
                
                // Tornar campos de PF obrigatórios
                document.getElementById('name').required = true;
                document.getElementById('cpf').required = true;
                document.getElementById('day_of_birth').required = true;
                
                // Remover obrigatoriedade dos campos de PJ
                document.getElementById('corporate_reason').required = false;
                document.getElementById('cnpj').required = false;
                document.getElementById('state_registration').required = false;
                document.getElementById('responsable').required = false;
            } else {
                formPF.classList.add('hidden');
                formPJ.classList.remove('hidden');
                btnPF.classList.remove('bg-botao', 'text-white');
                btnPF.classList.add('bg-input', 'text-gray-700');
                btnPJ.classList.add('bg-botao', 'text-white');
                btnPJ.classList.remove('bg-input', 'text-gray-700');
                userTypeInput.value = 'pj';
                
                // Tornar campos de PJ obrigatórios
                document.getElementById('corporate_reason').required = true;
                document.getElementById('cnpj').required = true;
                document.getElementById('state_registration').required = true;
                document.getElementById('responsable').required = true;
                
                // Remover obrigatoriedade dos campos de PF
                document.getElementById('name').required = false;
                document.getElementById('cpf').required = false;
                document.getElementById('day_of_birth').required = false;
            }
        }
        
        // Configurar eventos de clique
        btnPF.addEventListener('click', function() {
            toggleForms(true);
        });
        
        btnPJ.addEventListener('click', function() {
            toggleForms(false);
        });
        
        // Aplicar máscaras aos campos
        applyInputMasks();
        
        // Configurar busca de CEP
        setupCepSearch();
        
        // Mostrar/ocultar senha
        setupPasswordToggle();
        
        // Configurar envio do formulário
        setupFormSubmission();
    });
    
    function applyInputMasks() {
        // Máscara para CPF: 000.000.000-00
        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.substring(0, 11);
                
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                
                e.target.value = value;
            });
        }
        
        // Máscara para CNPJ: 00.000.000/0000-00
        const cnpjInput = document.getElementById('cnpj');
        if (cnpjInput) {
            cnpjInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 14) value = value.substring(0, 14);
                
                value = value.replace(/(\d{2})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1/$2');
                value = value.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
                
                e.target.value = value;
            });
        }
        
        // Máscara para CEP: 00000-000
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 8) value = value.substring(0, 8);
                
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
                
                e.target.value = value;
            });
        }
        
        // Máscara para telefone: (00)00000-0000 ou (00)0000-0000
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.substring(0, 11);
                
                // Formato para celular (11 dígitos): (00)00000-0000
                if (value.length === 11) {
                    value = '(' + value.substring(0, 2) + ')' + value.substring(2, 7) + '-' + value.substring(7);
                } 
                // Formato para telefone fixo (10 dígitos): (00)0000-0000
                else if (value.length === 10) {
                    value = '(' + value.substring(0, 2) + ')' + value.substring(2, 6) + '-' + value.substring(6);
                }
                // Formato parcial
                else if (value.length > 2) {
                    value = '(' + value.substring(0, 2) + ')' + value.substring(2);
                }
                
                e.target.value = value;
            });
        }
        
        // Máscara para data: DD/MM/AAAA
        const dateInput = document.getElementById('day_of_birth');
        if (dateInput) {
            dateInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 8) value = value.substring(0, 8);
                
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }
                if (value.length > 5) {
                    value = value.substring(0, 5) + '/' + value.substring(5);
                }
                
                e.target.value = value;
                
                // Atualizar o campo oculto com o formato YYYY-MM-DD
                updateFormattedDate(value);
            });
            
            // Também atualizar quando o campo perder o foco
            dateInput.addEventListener('blur', function() {
                updateFormattedDate(dateInput.value);
            });
        }
        
        // Máscara para número de endereço (apenas números)
        const addressNumberInput = document.getElementById('address_number');
        if (addressNumberInput) {
            addressNumberInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }
    }
    
    // Função para converter data de DD/MM/AAAA para YYYY-MM-DD
    function updateFormattedDate(dateString) {
        const formattedDateInput = document.getElementById('day_of_birth_formatted');
        if (!formattedDateInput) return;
        
        // Limpar caracteres não numéricos
        const cleanDate = dateString.replace(/\D/g, '');
        
        // Verificar se a data tem 8 dígitos (DDMMAAAA)
        if (cleanDate.length === 8) {
            const day = cleanDate.substring(0, 2);
            const month = cleanDate.substring(2, 4);
            const year = cleanDate.substring(4, 8);
            
            // Verificar se os valores são válidos
            if (parseInt(day) > 0 && parseInt(day) <= 31 && 
                parseInt(month) > 0 && parseInt(month) <= 12 && 
                parseInt(year) >= 1900 && parseInt(year) <= new Date().getFullYear()) {
                
                // Formatar como YYYY-MM-DD para o MySQL
                formattedDateInput.value = `${year}-${month}-${day}`;
            }
        }
    }
    
    function setupCepSearch() {
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('blur', function() {
                const cep = cepInput.value.replace(/\D/g, '');
                
                if (cep.length === 8) {
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                document.getElementById('address_street').value = data.logradouro;
                                document.getElementById('neighborhood').value = data.bairro;
                                document.getElementById('address_city').value = data.localidade;
                                
                                // Encontrar o estado correspondente no dropdown
                                const stateSelect = document.getElementById('state_id');
                                const stateOptions = stateSelect.options;
                                
                                for (let i = 0; i < stateOptions.length; i++) {
                                    const option = stateOptions[i];
                                    const optionText = option.text.trim();
                                    
                                    if (optionText === data.uf || optionText.includes(data.uf)) {
                                        stateSelect.selectedIndex = i;
                                        break;
                                    }
                                }
                            }
                        })
                        .catch(error => console.error('Erro ao buscar CEP:', error));
                }
            });
        }
    }
    
    function setupPasswordToggle() {
        // Mostrar/ocultar senha
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordField = document.getElementById(this.dataset.target);
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Alternar ícone
                const eyeOpen = this.querySelector('.eye-open');
                const eyeClosed = this.querySelector('.eye-closed');
                
                if (type === 'text') {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                } else {
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                }
            });
        });
    }
    
    function setupFormSubmission() {
        const form = document.getElementById('registration-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Verificar se estamos no formulário PF
                if (document.getElementById('user_type').value === 'pf') {
                    const dateInput = document.getElementById('day_of_birth');
                    const formattedDateInput = document.getElementById('day_of_birth_formatted');
                    
                    if (dateInput && formattedDateInput) {
                        // Converter a data para o formato YYYY-MM-DD
                        const dateParts = dateInput.value.split('/');
                        if (dateParts.length === 3) {
                            const day = dateParts[0];
                            const month = dateParts[1];
                            const year = dateParts[2];
                            
                            // Verificar se os valores são válidos
                            if (parseInt(day) > 0 && parseInt(day) <= 31 && 
                                parseInt(month) > 0 && parseInt(month) <= 12 && 
                                parseInt(year) >= 1900 && parseInt(year) <= new Date().getFullYear()) {
                                
                                // Formatar como YYYY-MM-DD para o MySQL
                                dateInput.value = `${year}-${month}-${day}`;
                            }
                        }
                    }
                }
            });
        }
    }
</script>
@endpush
@endsection
