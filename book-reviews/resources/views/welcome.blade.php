@extends('layouts.app')

@section('content')

    {{-- ╔══════════════════════════════════════════════╗
    ║ HERO ║
    ╚══════════════════════════════════════════════╝ --}}
    <section class="relative py-20 text-center overflow-hidden">

        {{-- Decoración de fondo: círculo difuminado en ámbar --}}
        <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
            <div class="h-72 w-72 rounded-full bg-amber-100/60 blur-3xl"></div>
        </div>

        {{-- Etiqueta tipo pill sobre el título --}}
        <span class="relative mb-6 inline-block rounded-full border border-amber-300 bg-amber-50
                         px-4 py-1 text-xs font-semibold uppercase tracking-widest text-amber-700">
            Your reading community
        </span>

        {{-- Título principal con tipografía editorial --}}
        <h1 class="font-display relative text-5xl font-bold leading-tight text-stone-900 mb-6
                       md:text-6xl">
            Discover Your Next<br>
            <em class="text-amber-700 not-italic">Favorite Book</em> 📚
        </h1>

        {{-- Subtítulo descriptivo --}}
        <p class="relative mx-auto max-w-md text-base text-stone-500 mb-10 font-light leading-relaxed">
            Read reviews, rate books, and discover the most popular titles
            from readers around the world.
        </p>

        {{-- CTA principal --}}
        <div class="relative flex justify-center gap-3">
            <a href="{{ route('books.index') }}" class="btn text-base px-8 py-3 h-auto shadow-md hover:shadow-lg">
                Browse Books
            </a>
        </div>

        {{-- Separador decorativo --}}
        <div class="relative mt-16 flex items-center gap-4 text-stone-300">
            <div class="flex-1 h-px bg-stone-200"></div>
            <span class="text-xs uppercase tracking-widest text-stone-400">Features</span>
            <div class="flex-1 h-px bg-stone-200"></div>
        </div>

    </section>


    {{-- ╔══════════════════════════════════════════════╗
    ║ FEATURE CARDS ║
    ╚══════════════════════════════════════════════╝ --}}
    <section class="grid md:grid-cols-3 gap-5 mt-10">

        {{-- Feature 1: Track Books --}}
        <div class="group rounded-2xl bg-white p-6 ring-1 ring-stone-200 shadow-sm
                        hover:shadow-md hover:-translate-y-1 transition-all duration-200">

            {{-- Ícono con fondo coloreado --}}
            <div class="mb-4 inline-flex h-11 w-11 items-center justify-center
                            rounded-xl bg-blue-50 text-2xl">
                📖
            </div>

            <h3 class="font-display text-lg font-semibold text-stone-900 mb-2">
                Track Books
            </h3>

            <p class="text-sm text-stone-500 font-light leading-relaxed">
                Keep track of the books you've read and those you want to read next.
            </p>
        </div>


        {{-- Feature 2: Rate & Review --}}
        <div class="group rounded-2xl bg-white p-6 ring-1 ring-stone-200 shadow-sm
                        hover:shadow-md hover:-translate-y-1 transition-all duration-200">

            <div class="mb-4 inline-flex h-11 w-11 items-center justify-center
                            rounded-xl bg-amber-50 text-2xl">
                ⭐
            </div>

            <h3 class="font-display text-lg font-semibold text-stone-900 mb-2">
                Rate & Review
            </h3>

            <p class="text-sm text-stone-500 font-light leading-relaxed">
                Share your opinion and rate books with our growing community of readers.
            </p>
        </div>


        {{-- Feature 3: Discover Popular Books --}}
        <div class="group rounded-2xl bg-white p-6 ring-1 ring-stone-200 shadow-sm
                        hover:shadow-md hover:-translate-y-1 transition-all duration-200">

            <div class="mb-4 inline-flex h-11 w-11 items-center justify-center
                            rounded-xl bg-rose-50 text-2xl">
                🔥
            </div>

            <h3 class="font-display text-lg font-semibold text-stone-900 mb-2">
                Discover Popular Books
            </h3>

            <p class="text-sm text-stone-500 font-light leading-relaxed">
                Find the highest rated books based on real, verified reader reviews.
            </p>
        </div>

    </section>

@endsection