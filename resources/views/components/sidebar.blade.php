@vite('resources/css/app.css')
<aside class="w-64 bg-orange-400 text-white flex-shrink-0">
    <div class="p-6">
             <h1 class="text-3xl font-bold">SGFrota</h1>
    </div>
    <nav class="mt-6">
        {{-- A variável $links vem automaticamente da classe Sidebar.php --}}
        @foreach ($links as $link)
            <a
                href="{{ $link['url'] }}"
                class="block py-2.5 px-6 transition duration-200 hover:bg-gray-700
                       'bg-gray-700 text-white' : 'text-gray-400' }}"
            >
                {{ $link['title'] }}
            </a>
        @endforeach
    </nav>
</aside>