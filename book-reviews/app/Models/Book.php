<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;

    // Relación: un libro puede tener muchas reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scope para filtrar libros por título (búsqueda parcial)
    public function scopeTitle(Builder $query, string $title): Builder
    {
        // Busca libros cuyo título contenga el texto enviado
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    // Scope para obtener libros más populares (con más reviews)
    // Opcionalmente filtrando por rango de fechas
    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            // Cuenta la cantidad de reviews
            // y aplica un filtro de fechas si se proporciona
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
            // Ordena los libros por cantidad de reviews (de mayor a menor)
            ->orderBy('reviews_count', 'desc');
    }

    // Scope para obtener libros con mejor rating promedio
    // También permite filtrar reviews por rango de fechas
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg([
            // Calcula el promedio del campo "rating"
            // aplicando filtro de fechas si existe
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            // Ordena de mayor rating promedio a menor
            ->orderBy('reviews_avg_rating', 'desc');
    }

    // Scope para filtrar libros que tengan al menos cierta cantidad de reviews
    public function scopeMinReviews(Builder $query, int $minReviews): Builder|QueryBuilder
    {
        // Filtra resultados donde el conteo de reviews sea mayor o igual al mínimo indicado
        return $query->having('reviews_count', '>=', $minReviews);
    }

    // Método privado para aplicar filtros de fecha a las reviews
    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        // Si solo existe fecha inicial
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } 
        // Si solo existe fecha final
        elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } 
        // Si existen ambas fechas
        elseif ($from && $to) {
            // Filtra entre las dos fechas
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}