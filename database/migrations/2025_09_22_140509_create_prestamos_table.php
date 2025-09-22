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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_prestamo');
            $table->timestamp('fecha_devolucion_estimada');
            $table->timestamp('fecha_devolucion_real')->nullable();
            $table->string('estado', 20)->default('activo');
            $table->foreignId('usuario_id')->constrained('usuarios')->onUpdate('cascade')->onDelete('no action');
            $table->foreignId('libro_id')->constrained('libros')->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};