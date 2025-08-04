@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Central de Cadastros</h1>

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

        <!-- Botão: Cadastrar Caminhão -->
        {{-- <a href="{{ route('cadastro.caminhoes.create') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h8a1 1 0 001-1zM14 9h4l3 4v4h-1" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Caminhões</h2>
                    <p class="text-gray-500 mt-1">Adicionar novo veículo à frota</p>
                </div>
            </div>
        </a> --}}

    </div>
@endsection
