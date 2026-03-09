<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view("books.reviews.create", ["book" => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)  // ✅ Recibe $book por route model binding
    {
        $data = $request->validate([
            'review' => 'required|string|max:1000',  // ✅ Coincide con la columna real
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $book->reviews()->create($data);  // ✅ Más limpio, book_id lo inyecta la relación

        cache()->forget('book:' . $book->id);

        // ✅ Invalida también el cache de la lista (todas las variantes de filtro)
        foreach (['', 'popular_last_month', 'popular_last_6months', 'highest_rated_last_month', 'highest_rated_last_6months'] as $filter) {
            cache()->forget('books:' . $filter . ':');
        }

        return redirect()->route('books.show', $book)
            ->with('success', 'Review agregada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
