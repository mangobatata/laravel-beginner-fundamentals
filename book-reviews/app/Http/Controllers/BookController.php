<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtiene el valor del parámetro "title" enviado en la URL o en el formulario.
        // Ejemplo: /books?title=harry
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        // Consulta los libros en la base de datos
        $books = Book::when(
            $title, // Condición: si $title tiene un valor (no es null o vacío)

            // Si existe $title, se ejecuta esta función
            // $query es el constructor de consultas de Eloquent
            // $title es el valor recibido del request
            fn($query, $title) => $query->title($title)
            // Se aplica el scope "title" del modelo Book para filtrar libros por título
        );


        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()
        };
        $books = $books->get();

        // Retorna la vista "books.index"
        // y le pasa la variable $books con los resultados
        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
