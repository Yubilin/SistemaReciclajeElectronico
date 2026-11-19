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
        Schema::create('recepcions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('observaciones');
            $table->string('estado');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('entregante_id')->constrained('entregantes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepcions');
    }
};
