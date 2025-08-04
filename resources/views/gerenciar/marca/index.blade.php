@extends('layout')

@section('content')
    {{-- Cabeçalho da Página --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gerenciar Marcas</h1>
        <a href="{{ route('cadastro.marca.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
            + Adicionar Nova Marca
        </a>
    </div>

    {{-- Mensagem de Sucesso --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Tabela de Marcas --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $marca->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $marca->marca }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            <a href="{{ route('gerenciar.marca.edit', $marca->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            
                            <form action="{{ route('gerenciar.marca.destroy', $marca->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja apagar esta marca?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Apagar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Esta mensagem é exibida se $marcas estiver vazio --}}
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nenhuma marca encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Links de Paginação --}}
        <div class="mt-6">
            {{ $marcas->links() }}
        </div>
    </div>
@endsection
