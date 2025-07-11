<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="/login" method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
        <img src="logo.jpeg" class="w-44 h-44 mx-auto mb-6">
        @csrf
        <label for="name" class="block text-gray-700 mb-2">Usuário:</label>
        <input type="text" id="name" name="name" required class="w-full px-3 py-2 mb-4 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">

        <label for="password" class="block text-gray-700 mb-2">Senha:</label>
        <input type="password" id="password" name="password" required class="w-full px-3 py-2 mb-6 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Login</button>
    </form>
</div>