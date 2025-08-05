<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <title>SGFrota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen bg-gray-200">
        
        <x-sidebar />
        
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- 2.1. TOPBAR -->
            <!-- A topbar deve ser incluída aqui, se você tiver uma. -->
            {{-- @include('layouts.partials.topbar') --}}
            
           
            <main class="flex-1 p-6">
                @yield('content')
                
            </main>
        </div>
        <x-logout />
    </div>
    
</body>
</html>
