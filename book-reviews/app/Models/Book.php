<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // HasFactory → trait que permite crear fábricas para pruebas o seeders
    use HasFactory;

    /**
     * Relación con reviews
     *
     * Un libro puede tener muchas reviews (uno a muchos)
     * Laravel espera que la tabla 'reviews' tenga una columna 'book_id'
     * que referencia al 'id' del libro.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        // Define la relación: Book "tiene muchas" Review
        return $this->hasMany(Review::class);
    }
}
