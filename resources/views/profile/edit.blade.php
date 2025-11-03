@extends('layout')

@section('title', 'Configurações do Perfil')
@section('help')
    <p>Atualize seu username ou redefina a senha da conta diretamente nesta tela.</p>
    <p>Informe a senha atual para confirmar alterações de senha e salve ao finalizar.</p>
@endsection

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Configurações do Perfil</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

    <form action="{{-- route('profile.update') --}}" method="POST" id="profile_form">
            @csrf
            @method('PUT') {{-- Ou PATCH --}}

            <!-- Campo Nome de Utilizador -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->username) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('username') border-red-500 @else border-gray-300 @enderror">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t my-6"></div>

            <p class="text-gray-600 mb-4">Senha</p>
            <!-- Campo Senha Atual -->
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">Senha Atual</label>
                <input type="password" id="current_password" name="current_password"
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('current_password') border-red-500 @else border-gray-300 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Campo Nova Senha -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                <input type="password" id="password" name="password"
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('password') border-red-500 @else border-gray-300 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Confirmação de Senha -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm border-gray-300">
                <p id="password_match_error" class="text-red-500 text-xs mt-1 hidden">As senhas não coincidem.</p>
            </div>

            <!-- Botão de Submissão -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
    <script>
        (function(){
            const form = document.getElementById('profile_form');
            if (!form) return;
            const pwd = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');
            const err = document.getElementById('password_match_error');

            function checkMatch(){
                // Só valida se o usuário estiver tentando alterar a senha
                if (!pwd.value && !confirm.value) {
                    err.classList.add('hidden');
                    confirm.classList.remove('border-red-500');
                    return true;
                }
                const ok = pwd.value === confirm.value && pwd.value.length > 0;
                if (!ok) {
                    err.classList.remove('hidden');
                    confirm.classList.add('border-red-500');
                } else {
                    err.classList.add('hidden');
                    confirm.classList.remove('border-red-500');
                }
                return ok;
            }

            pwd.addEventListener('input', checkMatch);
            confirm.addEventListener('input', checkMatch);
            form.addEventListener('submit', function(e){
                if (!checkMatch()) {
                    e.preventDefault();
                }
            });
        })();
    </script>
@endsection
