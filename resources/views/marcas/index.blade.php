@extends('layout')

@section('title', 'Marcas')
@section('help')
    <p>Gerencie as marcas de veículos cadastradas para utilizar em modelos e caminhões.</p>
    <p>Filtre a lista conforme necessário e use o link Editar para atualizar cada registro.</p>
@endsection

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-5xl mx-auto">
    {{-- Filtros --}}
    <form method="GET" action="{{ route('marcas.index') }}" class="flex flex-wrap items-center gap-3 mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar marca..."
               class="border border-gray-300 rounded px-3 py-2 w-64">
        <select name="per_page" class="border border-gray-300 rounded px-3 py-2">
            @foreach ([10,25,50,100] as $n)
                <option value="{{ $n }}" {{ (int)request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }} por página</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Aplicar</button>
        @if(request()->hasAny(['q','per_page']))
            <a href="{{ route('marcas.index') }}" class="text-sm text-gray-600 underline">Limpar filtros</a>
        @endif
    </form>

    {{-- Lista de Marcas (sem exibir ID) --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded">
            <thead class="bg-gray-50">
                <tr>
                    {{-- Removido o cabeçalho do ID --}}
                    <th class="text-left px-4 py-2">Marca</th>
                    <th class="text-left px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($marcas as $marca)
                    <tr class="border-t">
                        {{-- Removido o ID: não exibir $marca->id --}}
                        <td class="px-4 py-2">{{ $marca->marca }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('marcas.edit', $marca) }}" class="text-blue-600 underline">Editar</a>
                            {{-- ...existing code (outros botões/ações, se houver)... --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-3 text-gray-500" colspan="2">Nenhuma marca encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação (mantém filtros) --}}
    <div class="mt-4">
        {{ $marcas->appends(request()->query())->links() }}
    </div>
</div>
@endsection
