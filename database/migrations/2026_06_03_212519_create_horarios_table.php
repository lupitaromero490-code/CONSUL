<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctores')->cascadeOnDelete();
            $table->enum('dia', ['lunes','martes','miercoles','jueves','viernes','sabado','domingo']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('margen_minutos')->default(15);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};