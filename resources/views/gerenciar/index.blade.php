@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Gerenciar Dados do Sistema</h1>

    <p class="text-gray-600 mb-10">
        Selecione uma das opções abaixo para editar ou apagar dados do sistema.
    </p>

    <!-- Grid com os botões de opção -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- Botão: Gerir Marcas -->
        <a href="{{ route('gerenciar.marca.index') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Marcas</h2>
                    <p class="text-gray-500 mt-1">Editar e apagar marcas</p>
                </div>
            </div>
        </a>

        <!-- Botão: Gerir Modelos -->
        <a href="{{ route('gerenciar.modelo.index') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Modelos</h2>
                    <p class="text-gray-500 mt-1">Editar e apagar modelos</p>
                </div>
            </div>
        </a>

        <!-- Botão: Gerir Utilizadores -->
        <a href="{{-- route('gerenciar.usuarios.index') --}}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <!-- Ícone -->
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-8 h-8 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.663l.001.109m-8.381 3.663c.045.012.09.023.135.034M15 19.128L15 15.111v-2.167c-1.207.576-2.506.926-3.874.926-1.368 0-2.667-.35-3.874-.926V15.11L8.624 19.128z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl font-bold text-gray-800">Users</h2>
                    <p class="text-gray-500 mt-1">Editar e apagar users</p>
                </div>
            </div>
        </a>

    </div>
@endsection
