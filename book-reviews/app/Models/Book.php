<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * Scope para filtrar libros por título.
     *
     * Este método permite buscar libros cuyo título contenga una cadena específica.
     * Se usa con Eloquent como: Book::title('palabra')->get();
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $title La cadena a buscar dentro del título
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTitle(Builder $query, string $title): Builder
    {
        // Agrega una condición WHERE usando LIKE para buscar coincidencias parciales en la columna 'title'
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }
}
