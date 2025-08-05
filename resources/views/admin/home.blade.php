@extends('layout')

@section('content')
    <br>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Painel de Controle</h1>
    <br><br>
    <!-- Grid com os botões de função -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- Botão: Central de Cadastros -->
        <a href="{{ route('cadastro.index') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-blue-100 rounded-full">
                     <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Cadastros</h2>
                    <p class="text-gray-500 mt-1">Adicionar novos itens</p>
                </div>
            </div>
        </a>

        <!-- Botão: Gerenciar Itens -->
        <a href="{{ route('gerenciar.index') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-8 h-8 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Gerenciar Dados</h2>
                    <p class="text-gray-500 mt-1">Editar e apagar dados</p>
                </div>
            </div>
        </a>

    </div>
@endsection
