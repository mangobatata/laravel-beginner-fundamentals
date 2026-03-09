@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Add Review for {{ $book->title }}</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf

        <label for="review">Review</label>
        <textarea name="review" id="review" required class="input mb-4">{{ old('review') }}</textarea>
        {{-- ✅ name="review" coincide con la validación; old() repopula tras error --}}

        <label for="rating">Rating</label>
        <select name="rating" id="rating" class="input mb-4" required>
            <option value="">Select a Rating</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>

        <button type="submit" class="btn">Add Review</button>
    </form>
@endsection