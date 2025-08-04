@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registar Novo Usuário</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('cadastro.user.store') }}" method="POST">
            @csrf

            <!-- Campo Username -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('username') border-red-500 @else border-gray-300 @enderror">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('password') border-red-500 @else border-gray-300 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Administrador (Checkbox) -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input id="isAdmin" name="isAdmin" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="isAdmin" class="ml-2 block text-sm text-gray-900">
                        Administrador
                    </label>
                </div>
                 @error('isAdmin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Botão de Submissão -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Registar User
                </button>
            </div>
        </form>
    </div>
@endsection
