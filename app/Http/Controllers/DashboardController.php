<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->esAdmin()) {
            $replica = new \App\Services\ReplicaService();
            $conexiones = $replica->verificarConexiones();

            $datos = [
                'total_doctores'     => Doctor::count(),
                'total_pacientes'    => User::where('rol', 'paciente')->count(),
                'total_citas'        => Cita::count(),
                'citas_hoy'          => Cita::whereDate('fecha', today())->count(),
                'citas_pendientes'   => Cita::where('estado', 'pendiente')->count(),
                'especialidades'     => Especialidad::count(),
            ];
            return view('dashboard.admin', compact('datos', 'conexiones'));
        }

        if ($user->esDoctor()) {
            $doctor = $user->doctor;
            $citas = Cita::where('doctor_id', $doctor->id)
                ->whereDate('fecha', today())
                ->orderBy('hora_inicio')
                ->get();
            $proximas = Cita::where('doctor_id', $doctor->id)
                ->where('estado', 'pendiente')
                ->where('fecha', '>=', today())
                ->orderBy('fecha')
                ->take(5)
                ->get();
            return view('dashboard.doctor', compact('citas', 'proximas', 'doctor'));
        }

        // Paciente
        $citas = Cita::where('user_id', $user->id)
            ->orderBy('fecha', 'desc')
            ->take(5)
            ->get();
        return view('dashboard.paciente', compact('citas'));
    }
}
