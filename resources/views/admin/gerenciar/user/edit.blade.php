@extends('layout')
@section('title', 'Editar Usuários')
@section('content')

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('admin.gerenciar.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

           <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Nome de usuário</label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                
            </div>

            <!-- Campo Password (Opcional) -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                <input type="password" id="password" name="password"
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('password') border-red-500 @else border-gray-300 @enderror"
                       placeholder="Deixe em branco para manter a atual">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Administrador (Checkbox) -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input id="isAdmin" name="isAdmin" type="checkbox" 
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                           @if(old('isAdmin', $user->isAdmin)) checked @endif>
                    <label for="isAdmin" class="ml-2 block text-sm text-gray-900">
                        Status de Administrador
                    </label>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.gerenciar.user.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection
