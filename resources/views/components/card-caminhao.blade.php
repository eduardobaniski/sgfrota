@props(['caminhao'])

<div class="bg-white rounded-lg shadow-md p-5 border-l-4">
    <div>
        <p>{{ $caminhao->placa }}</p>
        <p>{{ $caminhao->modelo }}</p>
    </div>
    <span>{{ $caminhao->status }}</span>
    <!-- ... resto do card -->
</div>