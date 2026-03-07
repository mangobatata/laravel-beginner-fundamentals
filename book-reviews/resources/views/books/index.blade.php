@extends('layouts.app')

@section('content')

    {{-- ── Encabezado de la página ──────────────────────────── --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-stone-900">Books</h1>
        <p class="mt-1 text-sm text-stone-400 font-light">Browse and discover your next great read</p>
    </div>


    {{-- ── Formulario de búsqueda ───────────────────────────── --}}
    {{-- Se envía por GET para mantener los parámetros en la URL y poder compartir resultados --}}
    <form method="GET" action="{{ route('books.index') }}" class="mb-5 flex items-center gap-2">

        {{-- Campo de texto para filtrar por título --}}
        <input type="text" name="title" placeholder="Search by title…" value="{{ request('title') }}"
            class="input h-10 flex-1" />

        {{-- Mantiene el filtro activo al realizar una búsqueda --}}
        <input type="hidden" name="filter" value="{{ request('filter') }}" />

        {{-- Botón de búsqueda --}}
        <button type="submit" class="btn">Search</button>

        {{-- Botón para limpiar todos los filtros --}}
        <a href="{{ route('books.index') }}" class="btn-outline">Clear</a>

    </form>


    {{-- ── Filtros de ordenamiento ──────────────────────────── --}}
    <div class="filter-container mb-6">

        @php
            /*
             * Array asociativo con los filtros disponibles.
             * Clave ($key)   → se envía en la URL como parámetro "filter"
             * Valor ($label) → texto visible para el usuario
             */
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular · Month',
                'popular_last_6months' => 'Popular · 6 Months',
                'highest_rated_last_month' => 'Top Rated · Month',
                'highest_rated_last_6months' => 'Top Rated · 6 Months',
            ];
        @endphp

        @foreach ($filters as $key => $label)
            {{--
            Enlace para activar cada filtro.

            route('books.index', [...request()->query(), 'filter' => $key])

            Desglose:
            - request()->query() → conserva todos los parámetros actuales (p.ej. la búsqueda por título)
            - 'filter' => $key → sobreescribe o añade el filtro seleccionado

            Resultado en URL:
            /books?title=dune&filter=popular_last_month
            --}}
            <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}" class="{{ request('filter') === $key || (request('filter') === null && $key === '')
                ? 'filter-item-active'
                : 'filter-item' }}">
                {{ $label }}
            </a>
        @endforeach

    </div>


    {{-- ── Lista de libros ──────────────────────────────────── --}}
    <ul class="space-y-3">

        {{-- @forelse muestra los libros si existen; si no, entra en @empty --}}
        @forelse ($books as $book)
            <li>
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between gap-3">

                        {{-- Información principal: título y autor --}}
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('books.show', $book) }}" class="book-title">
                                {{ $book->title }}
                            </a>
                            <span class="book-author">by {{ $book->author }}</span>
                        </div>

                        {{-- Puntuación y conteo de reseñas --}}
                        <div class="flex flex-col items-end gap-0.5">

                            {{-- Rating con icono de estrella --}}
                            <div class="flex items-center gap-1">
                                <span class="text-amber-500 text-sm">★</span>
                                <span class="book-rating">
                                    {{ number_format($book->reviews_avg_rating, 1) }}
                                </span>
                            </div>

                            {{-- Número de reseñas --}}
                            <div class="book-review-count">
                                {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>

                        </div>
                    </div>
                </div>
            </li>

        @empty
            {{-- Estado vacío cuando no hay resultados --}}
            <li>
                <div class="empty-book-item">
                    <p class="text-3xl mb-3">📭</p>
                    <p class="empty-text font-semibold text-base mb-1">No books found</p>
                    <p class="text-xs text-stone-400 mb-4">Try adjusting your search or filters</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse

    </ul>

@endsection