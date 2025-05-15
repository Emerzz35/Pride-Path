@extends('layouts.app')

@section('content')
<main class="bg-fundo min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Cabeçalho da página -->
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-titulo">Editar perfil</h1>
                <p class="text-destaque mt-1">Atualize suas informações pessoais</p>
            </div>

            <!-- Formulário -->
            <div class="p-6">
                <form action="{{ route('user-update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- Formulário dinâmico --}}
                    <div class="space-y-6">
                        @if ($tipo === 'pj')
                            @include('components.user-pj-form')
                        @else
                            @include('components.user-pf-form')
                        @endif
                    </div>

                    {{-- Endereço --}}
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-titulo mb-4">Endereço</h3>
                        @include('components.address-form')
                    </div>

                    <input type="hidden" name="user_type" value="{{ $tipo }}">
                    
                    <div class="pt-4 flex justify-end">
                        <x-button 
                            class="bg-botao text-white px-6 py-3 rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                            linkto='user-update'>
                            Salvar alterações
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dicas para preenchimento -->
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-titulo mb-4">Dicas para seu perfil</h2>
            
            <ul class="space-y-3 text-destaque">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Mantenha seus dados sempre atualizados para facilitar o contato</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Seu endereço é importante para conectar você com serviços próximos</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Você pode alterar sua foto de perfil na página do seu perfil</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Suas informações são protegidas e só serão compartilhadas conforme nossa política de privacidade</span>
                </li>
            </ul>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar máscaras aos campos
        applyInputMasks();
        
        // Configurar busca de CEP
        setupCepSearch();
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
        
        // Máscara para telefone: (00) 00000-0000
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.substring(0, 11);
                
                if (value.length > 2) {
                    value = '(' + value.substring(0, 2) + ') ' + value.substring(2);
                }
                if (value.length > 10) {
                    value = value.substring(0, 10) + '-' + value.substring(10);
                }
                
                e.target.value = value;
            });
        }
        
        // Máscara para data: 00/00/0000
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
</script>
@endpush
@endsection
