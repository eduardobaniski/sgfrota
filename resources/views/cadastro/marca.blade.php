@extends('layout')
@section('content')
<div class="container">
    <h2>Nova Marca</h2>
    <form action="/cadastro/marca" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome da Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Salvar</button>
            {{-- <a href="{{ route('marca.index') }}" class="btn btn-secondary">Voltar</a> --}}
        </div>
    </form>
</div>
@endsection