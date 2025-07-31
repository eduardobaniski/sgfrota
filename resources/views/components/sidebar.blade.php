@vite('resources/css/app.css')
<aside class="w-64 bg-orange-400 text-white flex-shrink-0">
    <div class="p-6">
        <img src="logo.png" alt="" class="w-50 h-50 mx-auto">
    </div>
    <nav class="mt-2">
        {{-- A variável $links vem automaticamente da classe Sidebar.php --}}
        @foreach ($links as $link)
            <a href="{{ $link['url'] }}" 
                        class="block py-2.5 px-6 transition duration-200 rounded m-2 hover:bg-gray-700
                       'bg-gray-700 text-white' : 'text-gray-400' }}">
                {{ $link['title'] }}
            </a>
        @endforeach
    </nav>
</aside>