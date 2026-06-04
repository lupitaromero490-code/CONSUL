<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->nullable()->after('rol');
            $table->date('fecha_nacimiento')->nullable()->after('telefono');
            $table->string('direccion')->nullable()->after('fecha_nacimiento');
            $table->string('alergias')->nullable()->after('direccion');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'fecha_nacimiento', 'direccion', 'alergias']);
        });
    }
};