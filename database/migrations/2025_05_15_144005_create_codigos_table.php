<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Ejecuta la migración para crear la tabla 'codigos'.
     */
    public function up(): void
    {
        Schema::create('codigos', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            // Relación con usuarios
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); // Si se elimina el usuario, se eliminan sus códigos

            // Relación con posts
            $table->foreignId('post_id')
                  ->constrained()
                  ->onDelete('cascade'); // Si se elimina el post, también sus códigos

            // Lenguaje de programación (ej. Java, Python...)
            $table->string('lenguaje', 50);

            // Fragmento de código (hasta 1000 caracteres)
            $table->text('codigo');

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Revierte la migración (elimina la tabla).
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos');
    }
};
