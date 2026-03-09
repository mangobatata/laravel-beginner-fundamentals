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

Route::resource('books', BookController::class)
    ->only(['index', 'show']);


Route::resource('books.reviews', ReviewController::class)
    ->scoped(['book'])
    ->only(['create', 'store']);