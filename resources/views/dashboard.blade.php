@extends('layout')
@section('title', 'Dashboard da Frota')
@section('help')
    <p>Esta visão geral lista rapidamente os caminhões disponíveis na frota e os principais alertas.</p>
    <p>Abra um card para ver detalhes, iniciar viagens ou acessar dados específicos do veículo selecionado.</p>
@endsection
@props(['caminhoes'])
@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <!-- Cria um grid para organizar os cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        <!-- Para cada caminhão na lista... -->
        @foreach ($caminhoes as $caminhao)
            <!-- ...use o molde 'truck-card' para criar um card -->
            <x-card-caminhao :caminhao="$caminhao" />
            
        @endforeach

    </div>
@endsection
    </body>
</html>