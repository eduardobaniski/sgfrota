<!-- resources/views/layouts/partials/topbar.blade.php -->

<header class="bg-white shadow-md p-4 flex justify-between items-center">

    <!-- Título da Página (Dinâmico) -->
    <div>
        <h2 class="text-xl font-semibold text-gray-700">
            @yield('title', 'Painel') {{-- Espaço reservado para o título --}}
        </h2>
    </div>

    <!-- Grupo de Informação do Utilizador, Ajuda e Logout -->
    <div class="flex items-center space-x-6">
        @hasSection('help')
            <button type="button"
                class="flex items-center gap-2 rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                data-help-open="page-help-modal"
                aria-haspopup="dialog"
                aria-controls="page-help-modal">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-indigo-500 text-xs font-semibold text-white">?</span>
                <span>Ajuda</span>
            </button>
        @endif

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

@hasSection('help')
    <div id="page-help-modal" class="fixed inset-0 z-40 hidden flex items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="page-help-title" aria-hidden="true">
        <div class="absolute inset-0 bg-black/40" data-help-close></div>
        <div class="relative z-10 w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between">
                <h3 id="page-help-title" class="text-lg font-semibold text-gray-900">Ajuda da página</h3>
                <button type="button" class="rounded-md p-1 text-gray-400 transition hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" data-help-close data-help-focus>
                    <span class="sr-only">Fechar ajuda</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="mt-4 space-y-3 text-sm text-gray-600">
                @yield('help')
            </div>
        </div>
    </div>
@endif
