<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Modelo Event que representa la tabla 'events' en la base de datos
class Event extends Model
{
    // Habilita el uso de factories (para testing o seeders)
    use HasFactory;

    /**
     * Relación: Un evento pertenece a un usuario
     * (muchos eventos pueden pertenecer a un mismo usuario)
     */
    public function user(): BelongsTo
    {
        // Define la relación inversa hacia el modelo User
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un evento tiene muchos asistentes
     * (un evento puede tener varios attendees)
     */
    public function attendees(): HasMany
    {
        // Define la relación con el modelo Attendee
        return $this->hasMany(Attendee::class);
    }
}
