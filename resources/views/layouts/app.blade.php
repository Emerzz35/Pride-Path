<!DOCTYPE html>
<html lang="Pt-Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <title>Pride Path</title>
    </head>
    <body>
        {{-- Setup padrão para todas as paginas --}}
        @include('components.header')

        @yield('content', 'Nenuhm conteudo renderizado')
    </body>
</html>