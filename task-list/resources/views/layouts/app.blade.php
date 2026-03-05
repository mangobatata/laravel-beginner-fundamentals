<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'TaskFlow')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
    rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style type="text/tailwindcss">
    @theme {
      --color-ink:          #0d0d0d;
      --color-paper:        #f7f4ef;
      --color-cream:        #ede9e0;
      --color-border:       #ddd8cc;
      --color-muted:        #8a8070;
      --color-accent:       #c8522a;
      --color-accent-light: #f0ddd4;
      --color-accent-dark:  #a03e1c;
      --color-success-bg:   #d6f0e0;
      --color-success-text: #1a5c35;
      --color-success-ring: #a8dfc0;
      --color-warn-bg:      #fef3cd;
      --color-warn-text:    #7a5200;
      --color-warn-ring:    #f0dfa0;

      --font-display: 'Syne', sans-serif;
      --font-body:    'DM Sans', sans-serif;

      --shadow-card:       0 1px 3px rgba(13,13,13,0.06), 0 4px 16px rgba(13,13,13,0.06);
      --shadow-card-hover: 0 2px 8px rgba(13,13,13,0.1), 0 8px 32px rgba(13,13,13,0.1);

      --radius-card: 12px;

      --animate-slide-down: slideDown 0.3s ease;
      --animate-fade-in:    fadeIn 0.2s ease;

      @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
      }
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to   { opacity: 1; transform: translateY(0); }
      }
    }
  </style>
  @yield('styles')
</head>

<body class="bg-paper font-body text-ink min-h-screen">

  {{-- ── TOPBAR ── --}}
  <nav
    class="sticky top-0 z-50 bg-paper/90 backdrop-blur-md border-b border-border h-[60px] flex items-center justify-between px-8">

    <a href="{{ route('tasks.index') }}"
      class="font-display font-extrabold text-xl text-ink tracking-tight flex items-center gap-2 no-underline hover:text-accent transition-colors">
      <span class="w-2 h-2 rounded-full bg-accent inline-block"></span>
      TaskFlow
    </a>

    <a href="{{ route('tasks.create') }}"
      class="inline-flex items-center gap-1.5 bg-accent hover:bg-accent-dark text-white text-sm font-medium px-3.5 py-1.5 rounded-lg transition-all duration-150 hover:-translate-y-px no-underline">
      + New Task
    </a>

  </nav>

  {{-- ── CONTENT ── --}}
  <main class="max-w-3xl mx-auto px-6 py-12 pb-24">

    @if (session()->has('success'))
      <div class="flex items-center gap-2 bg-success-bg text-success-text border border-success-ring
                    rounded-card px-4 py-3.5 mb-6 text-sm font-medium animate-slide-down">
        ✓ {{ session('success') }}
      </div>
    @endif

    @yield('content')

  </main>

</body>

</html>