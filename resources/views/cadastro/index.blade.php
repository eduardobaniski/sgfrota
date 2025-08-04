@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Cadastro</h1>

    <p class="text-gray-600 mb-10">
        Selecione uma das opções abaixo para gerenciar os dados do sistema.
    </p>

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

    <!-- Grid com os botões de opção -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- Botão: Cadastrar Marca -->
        <a href="/cadastro/marca" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Marcas</h2>
                    <p class="text-gray-500 mt-1">Cadastrar novas marcas</p>
                </div>
            </div>
        </a>

        <!-- Botão: Cadastrar Modelo -->
        <a href="/cadastro/modelo" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Modelos</h2>
                    <p class="text-gray-500 mt-1">Adicionar novos modelos</p>
                </div>
            </div>
        </a>

        <!-- Botão: Cadastrar Usuário -->
        <a href="/cadastro/user" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Usuários</h2>
                    <p class="text-gray-500 mt-1">Gerenciar usuários</p>
                </div>
            </div>
        </a>
</div>
@endsection
