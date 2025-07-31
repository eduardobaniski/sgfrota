@vite('resources/css/app.css')


<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="/login" method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
        <img src="logo.png" class="w-44 h-44 mx-auto mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            {{-- Alerta de Erro (Vermelho) --}}
            @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Acesso Negado</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif
        @csrf
        <label for="username" class="block text-gray-700 mb-2">Usuário:</label>
        <input type="text" id="username" name="username" required class="w-full px-3 py-2 mb-4 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">

        <label for="password" class="block text-gray-700 mb-2">Senha:</label>
        <input type="password" id="password" name="password" required class="w-full px-3 py-2 mb-6 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Login</button>
    </form>
</div>