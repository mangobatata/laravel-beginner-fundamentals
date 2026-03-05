<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // HasFactory → trait que permite crear fábricas para pruebas o seeders
    use HasFactory;

    /**
     * Relación con Book
     *
     * Una review pertenece a un solo libro (muchos a uno)
     * Laravel espera que la tabla 'reviews' tenga una columna 'book_id'
     * que referencia al 'id' del libro.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        // Define la relación: Review "pertenece a" Book
        return $this->belongsTo(Book::class);
    }
}
