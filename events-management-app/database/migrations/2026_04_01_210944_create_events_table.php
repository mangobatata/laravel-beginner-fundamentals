<?php


use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Define una clase anónima que extiende de Migration
return new class extends Migration
{
    /**
     * Método que se ejecuta cuando corres la migración (php artisan migrate)
     */
    public function up(): void
    {
        // Crea una nueva tabla llamada 'events'
        Schema::create('events', function (Blueprint $table) {
            // Columna ID autoincremental (clave primaria)
            $table->id();

            // Crea una columna 'user_id' como clave foránea relacionada con la tabla users
            $table->foreignIdFor(User::class);

            // Nombre del evento (string obligatorio)
            $table->string('name');

            // Descripción del evento (texto opcional)
            $table->text('description')->nullable();

            // Fecha y hora de inicio del evento
            $table->dateTime('start_time');

            // Fecha y hora de finalización del evento
            $table->dateTime('end_time');

            // Crea columnas 'created_at' y 'updated_at'
            $table->timestamps();
        });
    }

    /**
     * Método que se ejecuta cuando haces rollback (php artisan migrate:rollback)
     */
    public function down(): void
    {
        // Elimina la tabla 'events' si existe
        Schema::dropIfExists('events');
    }
};