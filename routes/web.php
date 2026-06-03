<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\VentanillaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TurnoController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas autenticadas
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Solo admin
    Route::middleware(['auth'])->group(function () {
        Route::resource('especialidades', EspecialidadController::class);
        Route::resource('doctores', DoctorController::class);
        Route::resource('servicios', ServicioController::class);
        Route::resource('ventanillas', VentanillaController::class);
        Route::resource('pacientes', PacienteController::class);
        Route::resource('turnos', TurnoController::class);
    });

    // Doctores y admin
    Route::resource('consultas', ConsultaController::class);
    Route::get('consultas/{consulta}/pdf', [ConsultaController::class, 'pdf'])->name('consultas.pdf');
    Route::resource('horarios', HorarioController::class);

    // Todos los usuarios autenticados
    Route::resource('citas', CitaController::class);
    Route::get('citas/horarios-disponibles', [CitaController::class, 'horariosDisponibles'])->name('citas.horarios');
});

require __DIR__.'/auth.php';