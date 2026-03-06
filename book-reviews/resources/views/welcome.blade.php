@extends('layouts.app')

@section('content')

    <!-- HERO -->
    <section class="text-center py-20">

        <h1 class="text-5xl font-bold mb-6">
            Discover Your Next Favorite Book 📚
        </h1>

        <p class="text-lg text-gray-600 mb-10">
            Read reviews, rate books, and discover the most popular titles from readers around the world.
        </p>

        <div class="flex justify-center gap-4">

            <a href="{{ route('books.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Browse Books
            </a>



        </div>

    </section>


    <!-- FEATURES -->
    <section class="grid md:grid-cols-3 gap-8 mt-20">

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2">
                📖 Track Books
            </h3>

            <p class="text-gray-600">
                Keep track of the books you've read and those you want to read.
            </p>
        </div>


        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2">
                ⭐ Rate & Review
            </h3>

            <p class="text-gray-600">
                Share your opinion and rate books with the community.
            </p>
        </div>


        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2">
                🔥 Discover Popular Books
            </h3>

            <p class="text-gray-600">
                Find the highest rated books based on real reviews.
            </p>
        </div>

    </section>

@endsection