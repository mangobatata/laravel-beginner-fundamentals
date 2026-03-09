<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->string('voter_ip');
            $table->timestamps();

            $table->foreignIdFor(\App\Models\Option::class)
                ->constrained()
                ->cascadeOnDelete();

            // ✅ Un voto por opción por IP
            $table->unique(['option_id', 'voter_ip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
