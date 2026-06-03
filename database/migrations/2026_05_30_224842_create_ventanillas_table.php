<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventanillas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('numero');
            $table->enum('estado', ['activa', 'inactiva', 'en_pausa'])->default('inactiva');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventanillas');
    }
};