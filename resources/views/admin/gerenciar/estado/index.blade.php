@extends('layout')
@section('title', 'Gerir Estados')
@section('content')
    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('cadastro.estado.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
            + Adicionar Novo Estado
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

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-center gap-3 mb-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar estado..."
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sigla</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($estados as $estado)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $estado->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $estado->abbr }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            <a href="{{ route('admin.gerenciar.estado.edit', $estado->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            <form action="{{ route('admin.gerenciar.estado.destroy', $estado->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja apagar este estado?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Apagar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum estado encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $estados->appends(request()->query())->links() }}
        </div>
    </div>
@endsection