<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,700;1,300&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Fraunces', 'serif'],
                        mono: ['DM Mono', 'monospace'],
                        sans: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    @livewireStyles
</head>

<body class="min-h-screen bg-amber-50 text-zinc-900 font-sans font-light">

    {{-- Header ──────────────────────────────────────────── --}}
    <header class="bg-white border-b border-zinc-200">
        <div class="max-w-2xl mx-auto px-6 py-4 flex items-baseline gap-2">
            <span class="font-display text-xl font-bold tracking-tight">Pollr</span>
            <span class="font-mono text-[10px] text-orange-600 tracking-widest uppercase">beta</span>
        </div>
    </header>

    {{-- Main ────────────────────────────────────────────── --}}
    <main class="max-w-2xl mx-auto px-6 py-12">
        @yield('content')
    </main>

    @livewireScripts
</body>

</html>