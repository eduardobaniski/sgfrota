<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Admin</title>

    <!-- Garanta que o Vite está incluindo seus assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <!--
        ESTRUTURA PRINCIPAL
        'flex' ativa o layout Flexbox.
        'h-screen' faz com que esta div ocupe 100% da altura da tela.
    -->
    <div class="flex h-screen bg-gray-200">

        <!-- 1. SIDEBAR -->
        <!-- O componente da sidebar é chamado aqui. -->
        <x-sidebar />

        <!-- 2. ÁREA DE CONTEÚDO (DIREITA) -->
        <!--
            'flex-1' faz esta div crescer e ocupar todo o espaço disponível.
            'flex' e 'flex-col' a transformam em um container flex vertical.
            'overflow-y-auto' adiciona uma barra de rolagem se o conteúdo for muito grande.
        -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <!-- 2.1. TOPBAR -->
            <!-- A topbar deve ser incluída aqui, se você tiver uma. -->
            {{-- @include('layouts.partials.topbar') --}}

            <!-- 2.2. CONTEÚDO DA PÁGINA -->
            <!--
                'flex-1' garante que a área de conteúdo principal ocupe o espaço restante
                dentro do container vertical.
                'p-6' adiciona um espaçamento interno.
            -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
