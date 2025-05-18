@extends('layouts.app')

@section('content')
<main class="min-h-screen flex justify-center items-center py-10 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
        <div class="flex justify-center mb-6">
            <img src="/img/logo/LOGOTIPO-PRIDEPATH.svg" alt="Logo" class="h-16" />
        </div>
        
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Verificação de Email</h2>
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        <p class="text-gray-600 mb-6 text-center">
            Enviamos um código de verificação para <strong>{{ $email }}</strong>.<br>
            Por favor, verifique sua caixa de entrada e insira o código abaixo para completar seu cadastro.
        </p>
        
        <form action="{{ route('verify.email') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div>
                <label for="verification_code" class="block text-sm font-medium text-titulo mb-1">Código de Verificação</label>
                <input 
                    type="text" 
                    name="verification_code" 
                    id="verification_code" 
                    placeholder="Digite o código recebido" 
                    class="w-full bg-input rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-destaque text-center tracking-widest text-lg"
                    required
                    autocomplete="off"
                >
                @error('verification_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
                @enderror
            </div>
            
            <div class="flex flex-col items-center space-y-4">
                <button 
                    type="submit"
                    class="w-full py-3 bg-botao text-white rounded-xl hover:bg-opacity-90 transition-colors duration-200"
                >
                    Verificar e Criar Conta
                </button>
                
                <div class="text-sm text-gray-600">
                    Não recebeu o código? 
                    <a href="{{ route('resend.verification', ['email' => $email]) }}" class="text-link">
                        Reenviar código
                    </a>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
