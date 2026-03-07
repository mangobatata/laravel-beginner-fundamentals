@extends('layouts.app')

@section('content')

  {{-- ── Breadcrumb ────────────────────────────────────────── --}}
  <nav class="mb-6 text-xs text-stone-400 flex items-center gap-1.5">
    <a href="{{ route('books.index') }}" class="hover:text-stone-600 transition-colors">Books</a>
    <span>›</span>
    <span class="text-stone-600 font-medium">{{ $book->title }}</span>
  </nav>


  {{-- ── Cabecera del libro ───────────────────────────────── --}}
  <div class="mb-8 rounded-2xl bg-white ring-1 ring-stone-200 shadow-sm p-6">

    {{-- Título con tipografía editorial --}}
    <h1 class="font-display text-3xl font-bold text-stone-900 leading-tight mb-1">
      {{ $book->title }}
    </h1>

    {{-- Autor --}}
    <p class="text-stone-500 font-light mb-5">
      by <span class="font-medium text-stone-700">{{ $book->author }}</span>
    </p>

    {{-- Estadísticas: rating + conteo de reseñas --}}
    <div class="flex items-center gap-4">

      {{-- Puntuación grande con estrella --}}
      <div class="flex items-baseline gap-1.5">
        <span class="text-amber-500 text-xl">★</span>
        <span class="font-display text-2xl font-bold text-stone-900">
          {{ number_format($book->reviews_avg_rating, 1) }}
        </span>
        <span class="text-stone-400 text-sm">/ 5</span>
      </div>

      {{-- Divisor vertical --}}
      <div class="h-6 w-px bg-stone-200"></div>

      {{-- Conteo de reseñas --}}
      <span class="text-sm text-stone-500">
        {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
      </span>

    </div>
  </div>


  {{-- ── Sección de reseñas ───────────────────────────────── --}}
  <div>

    {{-- Encabezado de sección --}}
    <h2 class="font-display text-xl font-semibold text-stone-900 mb-4">
      Reader Reviews
    </h2>


    {{-- Lista de reseñas --}}
    <ul class="space-y-3">

      {{-- @forelse: itera sobre reseñas o muestra estado vacío --}}
      @forelse ($book->reviews as $review)
        <li>
          <div class="book-item">

            {{-- Fila superior: rating y fecha --}}
            <div class="mb-3 flex items-center justify-between">

              {{-- Estrellas generadas dinámicamente según el rating (1–5) --}}
              <div class="flex items-center gap-1">

                @for ($i = 1; $i <= 5; $i++)
                  {{-- Estrella llena si el índice <= rating; vacía en caso contrario --}} <span
                    class="{{ $i <= $review->rating ? 'star-fill' : 'star-empty' }} text-sm">
                    ★
                    </span>
                @endfor

                  {{-- Valor numérico del rating junto a las estrellas --}}
                  <span class="ml-1.5 text-xs font-semibold text-amber-700">
                    {{ $review->rating }}/5
                  </span>
              </div>

              {{-- Fecha de publicación de la reseña --}}
              <time class="book-review-count text-stone-400">
                {{ $review->created_at->format('M j, Y') }}
              </time>

            </div>

            {{-- Texto de la reseña --}}
            <p class="text-sm text-stone-600 leading-relaxed font-light">
              {{ $review->review }}
            </p>

          </div>
        </li>

      @empty
        {{-- Estado vacío cuando aún no hay reseñas --}}
        <li>
          <div class="empty-book-item">
            <p class="text-3xl mb-3">✍️</p>
            <p class="empty-text font-semibold text-base mb-1">No reviews yet</p>
            <p class="text-xs text-stone-400">Be the first to share your thoughts!</p>
          </div>
        </li>
      @endforelse

    </ul>

  </div>

@endsection