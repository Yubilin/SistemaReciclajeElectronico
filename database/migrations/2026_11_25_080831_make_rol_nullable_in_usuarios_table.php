<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Hacemos que la columna 'rol' pueda ser nula
            $table->string('rol')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Revertimos el cambio si fuera necesario
            $table->string('rol')->nullable(false)->change();
        });
    }
};