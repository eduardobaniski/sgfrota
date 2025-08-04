@extends('layout')
@props(['caminhoes'])
@section('content')

    <h1 class="text-3xl font-bold mb-6">Dashboard da Frota</h1>
    
    <!-- Cria um grid para organizar os cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Para cada caminhão na lista... -->
        @foreach ($caminhoes as $caminhao)
            <!-- ...use o molde 'truck-card' para criar um card -->
            <x-card-caminhao :caminhao="$caminhao" />
        @endforeach

    </div>
@endsection