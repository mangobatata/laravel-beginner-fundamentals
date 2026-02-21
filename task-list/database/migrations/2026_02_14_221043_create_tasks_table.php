<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // Título de la tarea (requerido)
            $table->text('description')->nullable();    // Descripción corta (opcional)
            $table->text('long_description')->nullable(); // Descripción detallada (opcional)
            $table->boolean('completed')->default(false); // Estado completado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
