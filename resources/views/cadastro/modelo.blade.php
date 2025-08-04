@extends('layout')
@props(['marcas'])
@section('content')
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Cadastrar Modelo</h2>
        <form action="/cadastro/modelo" method="POST">
        @csrf
        <div class="form-group mb-4">
            <label for="marca_id" class="block text-gray-700">Marca</label>
            <select class="form-control mt-1 block w-full p-2 border rounded" id="marca_id" name="marca_id" required>
                <option value="">Selecione uma Marca</option>
                @foreach($marcas as $id => $nome)
                    <option value="{{ $id }}">{{ $nome }}</option>
                @endforeach
            </select>
        </div>
            <div class="form-group mb-4">
                <label for="modelo" class="block text-gray-700">Nome do Modelo</label>
                <input type="text" class="form-control mt-1 block w-full p-2 border rounded" id="modelo" name="modelo" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Cadastrar
            </button>
        </form>
@endsection