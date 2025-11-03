@extends('layout')
@section('title', 'Editar Marcas')
@section('help')
    <p>Pesquise e atualize marcas existentes ou remova as que não são mais utilizadas.</p>
    <p>O botão Adicionar leva ao cadastro rápido; os links editam e o formulário apaga definitivamente.</p>
@endsection
@section('content')
    {{-- Cabeçalho da Página --}}
    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('cadastro.marca.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
            + Adicionar Nova Marca
        </a>
    </div>

     @if (session('success'))
        <div class="bg-green-100 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Barra de Busca --}}
    
    {{-- Tabela de Marcas --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-center gap-3 mb-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar marca..."
                   class="border border-gray-300 rounded px-3 py-2 w-64">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                Buscar
            </button>
            @if(request()->filled('q'))
                <a href="{{ url()->current() }}" class="text-sm text-gray-600 underline">Limpar</a>
            @endif
        </form>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    {{-- Removido o cabeçalho de ID --}}
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nome da Marca
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Ações</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($marcas as $marca)
                    <tr>
                        {{-- Removido o ID --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $marca->marca }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            <a href="{{ route('admin.gerenciar.marca.edit', $marca->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            
                            <form action="{{ route('admin.gerenciar.marca.destroy', $marca->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja apagar esta marca?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Apagar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Esta mensagem é exibida se $marcas estiver vazio --}}
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nenhuma marca encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Links de Paginação (mantém a busca) --}}
        <div class="mt-6">
            {{ $marcas->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
