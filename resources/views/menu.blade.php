@extends('layout')
@section('title', 'Menu Principal')
@section('help')
  <p>Escolha abaixo a área do sistema que deseja acessar. Você pode consultar caminhões, iniciar viagens, registrar abastecimentos e ver relatórios.</p>
@endsection
@section('content')
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
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <a href="{{ route('dashboard') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a.75.75 0 011.06 0L21.219 12M4.5 10.5V21h15V10.5" />
            </svg>
          </div>
          <div class="ml-5">
            <h2 class="text-xl font-bold text-gray-800">Status da frota</h2>
            <p class="text-gray-500 mt-1">Consultar o status dos caminhões da frota</p>
          </div>
        </div>
      </a>
    <!-- Caminhões -->
    <a href="{{ route('caminhoes.index') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
      <div class="flex items-center">
        <div class="p-3 bg-blue-100 rounded-full">
          <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 014.5-4.5h5.25A3.75 3.75 0 0115.75 14v1.5h1.5a2.25 2.25 0 110 4.5h-12a2.25 2.25 0 110-4.5h1.5V15z" />
          </svg>
        </div>
        <div class="ml-5">
          <h2 class="text-xl font-bold text-gray-800">Caminhões</h2>
          <p class="text-gray-500 mt-1">Consultar e gerenciar caminhões</p>
        </div>
      </div>
    </a>

    <!-- Viagens -->
    
    
    <!-- Motoristas -->
    <a href="{{ route('motorista.index') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
      <div class="flex items-center">
        <div class="p-3 bg-red-100 rounded-full">
          <svg class="w-8 h-8 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0V21H4.5v-1.5z" />
          </svg>
        </div>
        <div class="ml-5">
          <h2 class="text-xl font-bold text-gray-800">Motoristas</h2>
          <p class="text-gray-500 mt-1">Consultar e gerenciar motoristas</p>
        </div>
      </div>
    </a>
    <!-- Abastecimentos -->
    <a href="{{ route('abastecimentos.create') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
      <div class="flex items-center">
        <div class="p-3 bg-yellow-100 rounded-full">
        <svg class="w-8 h-8 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <rect x="1.5" y="6" width="21" height="12" rx="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <rect x="4.5" y="8.5" width="14" height="7" rx="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v4"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.2 11.5h3.6"/>
        </svg>
        </div>
        <div class="ml-5">
          <h2 class="text-xl font-bold text-gray-800">Abastecimentos</h2>
          <p class="text-gray-500 mt-1">Registrar novo abastecimento</p>
        </div>
      </div>
    </a>
    <!-- Relatórios (Consumo Geral) -->
    <a href="{{ route('consumos') }}" class="block p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
      <div class="flex items-center">
        <div class="p-3 bg-purple-100 rounded-full">
          <svg class="w-8 h-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M6 15l3-3 3 3 6-6" />
          </svg>
        </div>
        <div class="ml-5">
          <h2 class="text-xl font-bold text-gray-800">Relatórios</h2>
          <p class="text-gray-500 mt-1">Consumo geral da frota</p>
        </div>
      </div>
    </a>


  </div>
@endsection
