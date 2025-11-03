@extends('layout')
@section('title', 'Status da Frota')
@section('help')
    <p>Esta visão geral lista rapidamente os caminhões disponíveis na frota e os principais alertas.</p>
    <p>Abra um card para ver detalhes, iniciar viagens ou acessar dados específicos do veículo selecionado.</p>
@endsection
@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <!-- Pesquisa dentro da página -->
    <div class="mb-6 p-3 bg-white rounded-lg shadow-lg border border-gray-200 flex items-end gap-3">
        <div class="flex-1 relative">
            <label for="inpage-search" class="block text-sm font-semibold text-gray-800">Pesquisar nesta página</label>
            <svg class="absolute left-3 top-2/3 -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
            <input id="inpage-search" type="text" placeholder="Filtrar por placa, modelo ou marca" aria-label="Pesquisar nesta página"
                   class="mt-1 block w-full rounded-lg border border-indigo-300 bg-gray-50 py-3 pl-10 pr-4 text-base font-medium text-gray-900 placeholder-gray-400 shadow-sm
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>
        <button type="button" id="inpage-clear"
                class="flex items-center h-10 px-4 rounded-md bg-indigo-600 text-white text-sm font-medium shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Limpar
        </button>
    </div>

    <!-- Cria um grid para organizar os cards -->
    <div id="truckGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        <!-- Para cada caminhão na lista... -->
        @foreach ($caminhoes as $caminhao)
            <!-- ...use o molde 'truck-card' para criar um card -->
            <x-card-caminhao :caminhao="$caminhao" />
            
        @endforeach

    </div>

    <p id="noResultsMsg" class="mt-4 text-sm text-gray-500 hidden">Nenhum caminhão corresponde ao filtro informado.</p>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('inpage-search');
            const clearBtn = document.getElementById('inpage-clear');
            const grid = document.getElementById('truckGrid');
            const noResultsMsg = document.getElementById('noResultsMsg');

            function normalize(s) {
                return (s || '').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            }

            function applyFilter() {
                const term = normalize(input.value);
                let visibleCount = 0;

                Array.from(grid.children).forEach(card => {
                    const text = normalize(card.textContent);
                    const show = !term || text.includes(term);
                    card.classList.toggle('hidden', !show);
                    if (show) visibleCount++;
                });

                noResultsMsg.classList.toggle('hidden', visibleCount !== 0);
            }

            input.addEventListener('input', applyFilter);
            clearBtn.addEventListener('click', () => { input.value = ''; applyFilter(); input.focus(); });
        });
    </script>
@endsection