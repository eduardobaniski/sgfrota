@auth
    <h1>logado, {{ auth()->user()->name }}!</h1>
@else
    <x-login></x-login>
@endauth