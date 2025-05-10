<!DOCTYPE html>
<html lang="Pt-Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>Pride Path</title>
    </head>
    <body>
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
        @stack('scripts')
    </body>
</html>