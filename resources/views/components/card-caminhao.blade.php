@props(['caminhao'])
<!-- Card do Caminhão -->
<div class="bg-white rounded-lg shadow-md p-5 border-l-4 
    @switch($caminhao->status)
        @case('Em Trânsito') border-blue-500 @break
        @case('Disponível') border-green-500 @break
        @case('Em Manutenção') border-yellow-500 @break
        @default border-gray-400 @endswitch
">
    <!-- Header do Card: Placa e Status -->
    <div class="flex justify-between items-start mb-3">
        <div>
            <p class="text-xl font-bold text-gray-800 tracking-wider">{{ $caminhao->placa }}</p>
            <p class="text-sm text-gray-500">
                {{ $caminhao->modelo->marca->marca }} {{ $caminhao->modelo->modelo }}
            </p>
        </div>
        
        <!-- Badge de Status -->
        <span class="px-3 py-1 text-xs font-semibold text-white rounded-full
            @switch($caminhao->status)
                @case('Em Trânsito') bg-blue-500 @break
                @case('Disponível') bg-green-500 @break
                @case('Em Manutenção') bg-yellow-500 @break
                @default bg-gray-400 @endswitch
        ">
            {{ $caminhao->status }}
        </span>
    </div>
</div>