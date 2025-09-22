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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('tipo');
            $table->string('solicitante');
            $table->text('indicaciones');
            $table->date('fecha_planeada');
            $table->string('prioridad');
            $table->json('medio'); // Array de medios seleccionados
            $table->string('notion_page_id')->nullable(); // ID de la página en Notion
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('status');
            $table->index('tipo');
            $table->index('prioridad');
            $table->index('fecha_planeada');
            $table->index('solicitante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};