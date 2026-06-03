<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained()->cascadeOnDelete();
            $table->float('peso')->nullable();
            $table->float('talla')->nullable();
            $table->string('presion_arterial')->nullable();
            $table->text('sintomas');
            $table->text('diagnostico');
            $table->text('receta')->nullable();
            $table->text('notas_pendientes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};