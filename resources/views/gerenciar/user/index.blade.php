@extends('layout')

@section('content')
    {{-- Cabeçalho da Página --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gerenciar Usuários</h1>
        <a href="{{ route('cadastro.user.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
            + Adicionar Novo User
        </a>
    </div>

    {{-- Mensagens de Sucesso ou Erro --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Tabela de Utilizadores --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Username
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Função
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Ações</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{-- Loop para exibir cada utilizador --}}
                @forelse ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $user->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->username }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($user->isAdmin)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    Admin
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Gestor
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            {{-- Link para a rota de edição --}}
                            <a href="{{ route('gerenciar.user.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            
                            {{-- Formulário para a ação de apagar --}}
                            <form action="{{ route('gerenciar.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem a certeza que deseja apagar este user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Apagar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Mensagem exibida se não houver utilizadores --}}
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nenhum user encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
