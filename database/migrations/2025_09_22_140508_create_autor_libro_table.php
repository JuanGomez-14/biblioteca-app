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
        Schema::create('autor_libro', function (Blueprint $table) {
            $table->foreignId('autor_id')->constrained('autores')->onUpdate('cascade')->onDelete('no action');
            $table->foreignId('libro_id')->constrained('libros')->onUpdate('cascade')->onDelete('no action');
            $table->integer('orden_autor')->nullable();
            $table->primary(['autor_id', 'libro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor_libro');
    }
};