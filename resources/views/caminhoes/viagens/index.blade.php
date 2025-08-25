@extends('layout')

@section('title', 'Histórico de Viagens')

@section('content')
    {{-- Detalhes do Caminhão --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Histórico de Viagens</h1>
        <p class="text-gray-600 mt-1">
            Caminhão: <span class="font-bold text-gray-900">{{ $caminhao->placa }}</span> | 
            <span class="text-gray-800">{{ $caminhao->modelo->marca->marca }} {{ $caminhao->modelo->modelo }}</span>
        </p>
    </div>

    {{-- Mensagem de Sucesso --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Card principal que envolve a tabela --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-700">Viagens Realizadas</h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                &larr; Voltar ao Dashboard
            </a>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origem</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Início</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fim</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($viagens as $viagem)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $viagem->origem->name }} - {{ $viagem->origem->state->abbr }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $viagem->destino->name }} - {{ $viagem->destino->state->abbr }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($viagem->dataInicio)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $viagem->dataFim ? \Carbon\Carbon::parse($viagem->dataFim)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($viagem->dataFim)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Finalizada
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Em Andamento
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('viagens.edit', $viagem->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                Gerenciar viagem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Nenhuma viagem encontrada para este caminhão.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Links de Paginação --}}
        <div class="mt-6">
            {{ $viagens->links() }}
        </div>
    </div>
@endsection
