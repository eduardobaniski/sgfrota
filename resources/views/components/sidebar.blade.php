@vite('resources/css/app.css')
<aside class="w-64 bg-gray-800 text-white flex-shrink-0">
    <div class="p-6">
        <a href="#">
             <h1 class="text-2xl font-bold">Meu App</h1>
        </a>
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