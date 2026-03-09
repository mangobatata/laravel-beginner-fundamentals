<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    {{-- ✅ Tailwind CDN (sin Vite para esta app) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>

<body class="min-h-screen bg-stone-50">

    <main class="mx-auto max-w-3xl px-4 py-10">
        @yield('content')
    </main>

    @livewireScripts
</body>

</html>