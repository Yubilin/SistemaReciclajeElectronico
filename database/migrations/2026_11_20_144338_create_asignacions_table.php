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
        Schema::create('asignacions', function (Blueprint $table) {
            $table->id();
            $table->integer('numeroTurno');
            $table->date('fechaInicio');
            $table->date('fechaFinalizacion');
            $table->string('prioridad');
            $table->string('estado');
            $table->string('observacion');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('material_recibido_id')->constrained('material_recibidos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacions');
    }
};
