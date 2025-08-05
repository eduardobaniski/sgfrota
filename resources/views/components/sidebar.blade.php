<aside class="w-64 bg-orange-300 text-black flex-shrink-0">
    <div class="p-6">
        <img src="{{ asset('logo.png') }}" alt="" class="w-50 h-50 mx-auto">
    </div>
    <nav class="mt-2">
        @foreach ($links as $link)
            <a href="{{ $link['url'] }}" 
             class="block py-2.5 px-6 m-2 rounded font-semibold transition duration-200 hover:bg-white
            'bg-white text-orange-600'">
    {{ $link['title'] }}
</a>
        @endforeach
    </nav>
</aside>