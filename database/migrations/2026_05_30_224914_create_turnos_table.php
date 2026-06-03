<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_turno');
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ventanilla_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('estado', ['esperando', 'en_atencion', 'completado', 'ausente'])->default('esperando');
            $table->timestamp('hora_registro')->useCurrent();
            $table->timestamp('hora_llamada')->nullable();
            $table->timestamp('hora_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};