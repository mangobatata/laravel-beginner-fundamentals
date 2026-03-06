<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
// Alias para diferenciar el Builder de Eloquent del Builder de Query pura
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;

    /**
     * Relación: Un libro tiene muchas reviews.
     * Eloquent usará book_id en la tabla reviews para hacer el JOIN automáticamente.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * SCOPE: Filtrar libros por título (búsqueda parcial).
     *
     * Uso: Book::title('harry')->get()
     * SQL generado: WHERE title LIKE '%harry%'
     *
     * Los scopes siempre reciben $query como primer parámetro (Eloquent lo inyecta).
     * El segundo parámetro es el valor que pasamos al llamar el scope.
     */
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    /**
     * SCOPE: Ordenar libros por cantidad de reviews (más popular primero).
     *
     * Uso: Book::popular()->get()
     *      Book::popular('2024-01-01', '2024-12-31')->get()
     *
     * withCount() agrega una columna virtual "reviews_count" al SELECT,
     * contando las reviews relacionadas. Si se pasan fechas, filtra
     * solo las reviews dentro de ese rango antes de contar.
     *
     * SQL generado aproximado:
     * SELECT books.*, (SELECT COUNT(*) FROM reviews WHERE books.id = reviews.book_id ...) AS reviews_count
     * ORDER BY reviews_count DESC
     */
    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            // La clave 'reviews' hace referencia a la relación definida arriba.
            // La función callback recibe el subquery de reviews y le aplica el filtro de fechas.
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
        ->orderBy('reviews_count', 'desc'); // Más reviews primero
    }

    /**
     * SCOPE: Ordenar libros por rating promedio (mejor calificado primero).
     *
     * Uso: Book::highestRated()->get()
     *      Book::highestRated('2024-01-01', '2024-12-31')->get()
     *
     * withAvg() agrega una columna virtual "reviews_avg_rating" al SELECT,
     * calculando el promedio del campo "rating" de las reviews relacionadas.
     * Si se pasan fechas, filtra las reviews antes de promediar.
     *
     * SQL generado aproximado:
     * SELECT books.*, (SELECT AVG(rating) FROM reviews WHERE books.id = reviews.book_id ...) AS reviews_avg_rating
     * ORDER BY reviews_avg_rating DESC
     */
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg([
            // Igual que withCount, el callback aplica el filtro de fechas al subquery
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating') // 'rating' es el campo del que se calculará el promedio
        ->orderBy('reviews_avg_rating', 'desc'); // Mayor rating primero
    }

    /**
     * SCOPE: Filtrar libros que tengan al menos X cantidad de reviews.
     *
     * Uso: Book::popular()->minReviews(5)->get()
     *
     * ⚠️ IMPORTANTE — Por qué usamos havingRaw() en lugar de having():
     *
     * PostgreSQL NO permite usar alias del SELECT dentro del HAVING.
     * Ejemplo de lo que NO funciona en Postgres:
     *   HAVING reviews_count >= 5   ← "reviews_count" es un alias, Postgres lo rechaza
     *
     * Solución: repetir la subquery completa dentro del HAVING:
     *   HAVING (SELECT COUNT(*) FROM reviews WHERE books.id = reviews.book_id ...) >= 5
     *
     * También necesitamos GROUP BY books.id porque PostgreSQL exige que cuando
     * se usan funciones de agregación (COUNT, AVG) en HAVING u ORDER BY,
     * todas las columnas no agregadas del SELECT deben estar en GROUP BY.
     */
    public function scopeMinReviews(Builder $query, int $minReviews, $from = null, $to = null): Builder|QueryBuilder
    {
        // Comenzamos la subquery SQL manualmente
        $sql = '(select count(*) from "reviews" where "books"."id" = "reviews"."book_id"';
        $bindings = []; // Array de valores que reemplazarán los "?" en la query (previene SQL injection)

        // Agregamos el filtro de fechas a la subquery según los parámetros recibidos
        if ($from && !$to) {
            // Solo fecha de inicio: reviews desde $from hasta hoy
            $sql .= ' and "created_at" >= ?';
            $bindings[] = $from;
        } elseif (!$from && $to) {
            // Solo fecha de fin: reviews hasta $to
            $sql .= ' and "created_at" <= ?';
            $bindings[] = $to;
        } elseif ($from && $to) {
            // Rango completo: reviews entre $from y $to
            $sql .= ' and "created_at" between ? and ?';
            $bindings[] = $from;
            $bindings[] = $to;
        }

        // Cerramos la subquery y agregamos la condición mínima
        $sql .= ') >= ?';
        $bindings[] = $minReviews; // El "?" final se reemplaza por el mínimo de reviews

        return $query
            ->groupBy('books.id')       // ✅ Requerido por PostgreSQL (ver explicación arriba)
            ->havingRaw($sql, $bindings); // Ejecuta el HAVING con la subquery real
    }

    /**
     * Método privado auxiliar para aplicar filtros de fecha a un subquery de reviews.
     *
     * Se reutiliza en scopePopular() y scopeHighestRated() para no repetir
     * la misma lógica de fechas en cada scope.
     *
     * @param Builder $query  El subquery de reviews que se está construyendo
     * @param mixed   $from   Fecha de inicio (opcional)
     * @param mixed   $to     Fecha de fin (opcional)
     */
    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
        // Si no hay fechas, no se aplica ningún filtro y se cuentan todas las reviews
    }

    /**
     * SCOPE: Libros más populares del último mes.
     *
     * Combina 3 scopes encadenados:
     * 1. popular()       → ordena por cantidad de reviews del último mes
     * 2. highestRated()  → luego por rating promedio del último mes
     * 3. minReviews(2)   → filtra libros con al menos 2 reviews (evita resultados con pocos datos)
     *
     * Las mismas fechas se pasan a los 3 scopes para que todos filtren
     * el mismo período de tiempo de forma consistente.
     */
    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2, now()->subMonth(), now());
    }

    /**
     * SCOPE: Libros más populares de los últimos 6 meses.
     * Similar a popularLastMonth pero con ventana de 6 meses y mínimo 5 reviews.
     * El umbral más alto (5 vs 2) tiene sentido porque en 6 meses
     * un libro debería acumular más reviews para ser considerado relevante.
     */
    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())
            ->minReviews(5, now()->subMonths(6), now());
    }

    /**
     * SCOPE: Libros mejor calificados del último mes.
     *
     * Mismo concepto que popularLastMonth pero el orden de prioridad es inverso:
     * 1. highestRated()  → ordena primero por rating promedio
     * 2. popular()       → luego por cantidad de reviews como criterio secundario
     * 3. minReviews(2)   → mínimo 2 reviews para filtrar libros con pocos datos
     */
    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2, now()->subMonth(), now());
    }

    /**
     * SCOPE: Libros mejor calificados de los últimos 6 meses.
     * Similar a highestRatedLastMonth pero con ventana de 6 meses y mínimo 5 reviews.
     */
    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonths(6), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5, now()->subMonths(6), now());
    }
}