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

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Solo administrador
    Route::middleware(['rol:admin'])->group(function () {
        Route::resource('especialidades', EspecialidadController::class)
             ->parameters(['especialidades' => 'especialidad']);
        Route::resource('doctores', DoctorController::class)
             ->parameters(['doctores' => 'doctor']);
        Route::resource('servicios', ServicioController::class);
        Route::resource('ventanillas', VentanillaController::class);
        Route::resource('pacientes', PacienteController::class);
        Route::resource('turnos', TurnoController::class);
    });

    // Solo doctor
    Route::middleware(['rol:doctor'])->group(function () {
        Route::resource('horarios', HorarioController::class);
    });

    // Admin y doctor
    Route::middleware(['rol:admin,doctor'])->group(function () {
        Route::resource('consultas', ConsultaController::class);
        Route::get('consultas/{consulta}/pdf', [ConsultaController::class, 'pdf'])
             ->name('consultas.pdf');
    });

    // Horarios disponibles ANTES del resource
    Route::get('citas/horarios-disponibles', [CitaController::class, 'horariosDisponibles'])
         ->name('citas.horarios');

    // Todos los usuarios autenticados
    Route::resource('citas', CitaController::class);
});

require __DIR__ . '/auth.php';