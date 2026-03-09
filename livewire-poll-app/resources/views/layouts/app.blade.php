<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    {{-- Vite: CSS y JS compilados --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire 3: estilos (debe ir antes del cierre de
</head>) --}}
@livewireStyles
</head>

<body>
    @yield('content')

    @livewireScripts
</body>

</html>