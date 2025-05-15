<!DOCTYPE html>
<html lang="Pt-Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>Pride Path</title>
        @stack('styles')
    </head>
    <body class="bg-fundo min-h-screen">
        {{-- Setup padrão para todas as paginas --}}
        @include('components.header')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content', 'Nenuhm conteudo renderizado')
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @stack('scripts')
    </body>
</html>
