@props([
    'action',
    'confirmMessage' => 'Tem a certeza que deseja apagar este registo? Esta ação não pode ser desfeita.',
])

{{-- 
Este formulário é a forma segura de enviar um pedido de DELETE.
O 'onsubmit' aciona uma caixa de diálogo de confirmação no navegador.
Se o utilizador clicar em "Cancelar", a submissão do formulário é interrompida.
--}}
<form action="{{ $action }}" method="POST" class=" flex justify-end" onsubmit="return confirm('{{ $confirmMessage }}');">
    @csrf
    @method('DELETE')

    <button type="submit" {{ $attributes->merge(['class' => 'bg-red-500 hover:bg-red-600 text-white text-sm font-bold py-2 px-3 rounded-md transition-colors']) }}>
        {{-- 
        Verifica se foi passado algum conteúdo para o slot.
        Se não, usa o texto padrão "Apagar".
        Se sim (ex: um ícone e texto), exibe esse conteúdo.
        --}}
        {{ $slot->isEmpty() ? 'Apagar' : $slot }}
    </button>
</form>
