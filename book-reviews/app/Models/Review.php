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

    // Este método se ejecuta automáticamente cuando el modelo se inicializa
    // Sirve para registrar eventos del modelo (updated, deleted, etc.)
    protected static function booted()
    {
        // ================================================
        // protected static function booted()
        //
        // protected   -> Solo puede ser usado dentro de esta clase o sus subclases (no desde afuera)
        // static      -> Pertenece a la clase, no a una instancia específica del modelo
        // function    -> Define un método o función en PHP
        //
        // En conjunto:
        // Este método se ejecuta automáticamente al inicializar el modelo y
        // se usa para registrar eventos como updated o deleted de manera global.
        // ================================================


        // Evento que se dispara cuando una review se actualiza
        static::updated(
            fn(Review $review) =>
            // Borra del cache la clave del libro relacionado para mantener los datos actualizados
            cache()->forget('book:' . $review->book_id)
        );

        // Evento que se dispara cuando una review se elimina
        static::deleted(
            fn(Review $review) =>
            // Borra del cache la clave del libro relacionado para que el próximo acceso genere cache nuevo
            cache()->forget('book:' . $review->book_id)
        );
    }
}
