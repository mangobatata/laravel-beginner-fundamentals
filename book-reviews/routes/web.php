<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route("books.index");
});

// Route::resource('books', BookController::class);

// ── Libros ────────────────────────────────────────────────────
Route::resource('books', BookController::class)
    ->only(['index', 'show'])
    ->middleware([
        'index' => 'throttle:books-search',
        'show' => 'throttle:books-show',
    ]);

// ── Reviews ───────────────────────────────────────────────────
// create no necesita rate limiter (solo muestra el formulario)
// store sí lo necesita (escribe en la DB)
Route::resource('books.reviews', ReviewController::class)
    ->scoped(['book'])
    ->only(['create', 'store'])
    ->middleware([
        'store' => 'throttle:create-review',
    ]);