<!-- resources/views/layouts/partials/topbar.blade.php -->

<header class="bg-white shadow-md p-4 flex justify-between items-center">
    
    <!-- Título da Página (Dinâmico) -->
    <div>
        <h2 class="text-xl font-semibold text-gray-700">
            @yield('title', 'Painel') {{-- Espaço reservado para o título --}}
        </h2>
    </div>

    <!-- Grupo de Informação do Utilizador e Logout -->
    <div class="flex items-center space-x-8">
        <!-- Informação do Utilizador -->
        <div class="flex items-center">
            <span class="text-gray-600 text-sm mr-2">
                Sessão iniciada como:
            </span>
            <span class="font-semibold text-gray-800 text-sm">
                {{-- Acede ao nome do utilizador autenticado. Use 'username' se for o caso. --}}
                {{ Auth::user()->name ?? Auth::user()->username }}
            </span>
        </div>

        <!-- Botão de Logout -->
        <x-logout />
    </div>

</header>
