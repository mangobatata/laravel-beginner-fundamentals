<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 33 libros con reviews "good"
        Book::factory(33)->create()->each(function ($book) {
            // Genera un número aleatorio de reviews entre 5 y 30
            $numReviews = random_int(5, 30);

            // Crear esas reviews para el libro actual con estado "good"
            Review::factory()->count($numReviews)
                ->good()        // Estado definido en la factory para reviews positivas
                ->for($book)    // Asocia la review con el libro (book_id)
                ->create();
        });

        // Crear 33 libros con reviews "average"
        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            // Crear reviews promedio para el libro actual
            Review::factory()->count($numReviews)
                ->average()     // Estado definido en la factory para reviews promedio
                ->for($book)
                ->create();
        });

        // Crear 34 libros con reviews "bad"
        Book::factory(34)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            // Crear reviews malas para el libro actual
            Review::factory()->count($numReviews)
                ->bad()         // Estado definido en la factory para reviews negativas
                ->for($book)
                ->create();
        });
    }
}
