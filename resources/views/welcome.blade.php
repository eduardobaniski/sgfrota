@vite('resources/css/app.css')

@auth
    <h1>logado, {{ auth()->user()->name }}!</h1>
    
    <form action="/logout" method="POST">
        @csrf
        <button>Logout</button>
    </form>
@else
    <x-login />
@endauth