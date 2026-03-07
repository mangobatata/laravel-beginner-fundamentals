<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Reviews</title>

  {{-- Tailwind CSS v4 via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Google Fonts: Playfair Display para títulos + DM Sans para cuerpo --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">

  <style type="text/tailwindcss">

    /* ─── Variables de diseño ─────────────────────────────── */
    :root {
      --cream:   #F7F3EE;
      --ink:     #1C1917;
      --amber:   #B45309;
      --amber-light: #FEF3C7;
      --muted:   #78716C;
      --border:  #E7E0D8;
    }

    body {
      background-color: var(--cream);
      color: var(--ink);
      font-family: 'DM Sans', sans-serif;
    }

    /* ─── Utilidades tipográficas ─────────────────────────── */
    .font-display { font-family: 'Playfair Display', serif; }

    /* ─── Botón primario ──────────────────────────────────── */
    .btn {
      @apply inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-medium
             bg-stone-800 text-amber-50 shadow-sm
             hover:bg-stone-700 active:scale-95
             transition-all duration-200 h-10;
    }

    /* ─── Botón secundario / outline ─────────────────────── */
    .btn-outline {
      @apply inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-medium
             border border-stone-300 text-stone-600 bg-white shadow-sm
             hover:bg-stone-50 active:scale-95
             transition-all duration-200 h-10;
    }

    /* ─── Campo de texto ──────────────────────────────────── */
    .input {
      @apply w-full rounded-full border border-stone-300 bg-white px-4 py-2
             text-stone-800 placeholder-stone-400 shadow-sm
             focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent
             transition-all duration-200;
    }

    /* ─── Barra de filtros ────────────────────────────────── */
    .filter-container {
      @apply flex gap-1 rounded-full bg-stone-100 border border-stone-200 p-1.5 overflow-x-auto;
    }

    /* ─── Ítem de filtro inactivo ─────────────────────────── */
    .filter-item {
      @apply flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-medium text-stone-500
             hover:text-stone-700 hover:bg-white/60
             transition-all duration-150 whitespace-nowrap;
    }

    /* ─── Ítem de filtro activo ───────────────────────────── */
    .filter-item-active {
      @apply flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold
             bg-white text-stone-800 shadow-sm border border-stone-200
             transition-all duration-150 whitespace-nowrap;
    }

    /* ─── Tarjeta de libro en listado ────────────────────── */
    .book-item {
      @apply rounded-2xl bg-white p-5 leading-6 text-stone-900
             shadow-sm ring-1 ring-stone-200
             hover:shadow-md hover:-translate-y-0.5
             transition-all duration-200;
    }

    /* ─── Título del libro ────────────────────────────────── */
    .book-title {
      @apply font-display text-lg font-semibold text-stone-900 hover:text-amber-700
             transition-colors duration-150;
    }

    /* ─── Autor del libro ─────────────────────────────────── */
    .book-author {
      @apply block text-sm text-stone-500 font-light mt-0.5;
    }

    /* ─── Rating numérico ─────────────────────────────────── */
    .book-rating {
      @apply text-base font-semibold text-amber-700;
    }

    /* ─── Conteo de reseñas ───────────────────────────────── */
    .book-review-count {
      @apply text-xs text-stone-400 font-light;
    }

    /* ─── Estado vacío ────────────────────────────────────── */
    .empty-book-item {
      @apply rounded-2xl bg-white py-14 px-4 text-center
             ring-1 ring-stone-200 shadow-sm;
    }

    .empty-text {
      @apply font-medium text-stone-400 text-sm;
    }

    /* ─── Enlace de reset ─────────────────────────────────── */
    .reset-link {
      @apply text-amber-700 underline underline-offset-2 text-sm hover:text-amber-900
             transition-colors duration-150;
    }

    /* ─── Estrellas de rating ─────────────────────────────── */
    .star-fill   { color: #D97706; }
    .star-empty  { color: #D8D3CD; }

  </style>
</head>

<body class="min-h-screen">

  {{-- ── Header global ────────────────────────────────────── --}}
  <header class="sticky top-0 z-50 border-b border-stone-200 bg-[#F7F3EE]/80 backdrop-blur-md">
    <div class="container mx-auto max-w-3xl px-4 py-4 flex items-center justify-between">

      {{-- Logotipo / marca --}}
      <a href="/" class="font-display text-xl font-bold text-stone-900 tracking-tight">
        📚 Bibliophile
      </a>

      {{-- Navegación --}}
      <nav class="flex items-center gap-4 text-sm font-medium text-stone-600">
        <a href="{{ route('books.index') }}" class="hover:text-stone-900 transition-colors">Browse</a>
      </nav>

    </div>
  </header>

  {{-- ── Contenido principal ──────────────────────────────── --}}
  <main class="container mx-auto max-w-3xl px-4 py-10 mb-10">
    @yield('content')
  </main>

  {{-- ── Footer minimalista ───────────────────────────────── --}}
  <footer class="border-t border-stone-200 py-6 text-center text-xs text-stone-400">
    © {{ date('Y') }} Bibliophile · Crafted with ♥ for book lovers
  </footer>

</body>

</html>