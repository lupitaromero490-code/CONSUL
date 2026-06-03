<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->esAdmin()) {
            $citas = Cita::with(['doctor.user', 'paciente'])
                         ->orderBy('fecha')->get();
        } elseif ($user->esDoctor()) {
            $citas = Cita::with(['paciente'])
                         ->where('doctor_id', $user->doctor->id)
                         ->orderBy('fecha')->get();
        } else {
            $citas = Cita::with(['doctor.user', 'doctor.especialidad'])
                         ->where('user_id', $user->id)
                         ->orderBy('fecha')->get();
        }

        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $especialidades = Especialidad::where('activo', true)->get();
        $doctores = Doctor::with(['user', 'especialidad'])->where('activo', true)->get();
        return view('citas.create', compact('especialidades', 'doctores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'   => 'required|exists:doctores,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required',
            'motivo'      => 'nullable|string',
        ]);

        $doctor = Doctor::find($request->doctor_id);
        $duracion = $doctor->especialidad->duracion_consulta;
        $hora_fin = date('H:i', strtotime($request->hora_inicio . ' + ' . $duracion . ' minutes'));

        Cita::create([
            'doctor_id'   => $request->doctor_id,
            'user_id'     => auth()->id(),
            'fecha'       => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin'    => $hora_fin,
            'motivo'      => $request->motivo,
            'estado'      => 'pendiente',
        ]);

        return redirect()->route('citas.index')
                         ->with('success', 'Cita agendada correctamente');
    }

    public function show(Cita $cita)
    {
        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita)
    {
        $doctores = Doctor::with(['user', 'especialidad'])->where('activo', true)->get();
        return view('citas.edit', compact('cita', 'doctores'));
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,completada,cancelada',
        ]);

        $cita->modificar($request->estado);
        return redirect()->route('citas.index')
                         ->with('success', 'Cita actualizada correctamente');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')
                         ->with('success', 'Cita cancelada correctamente');
    }

    // AJAX - obtener horarios disponibles
    public function horariosDisponibles(Request $request)
    {
        $doctor = Doctor::find($request->doctor_id);
        $fecha = $request->fecha;
        $dia = strtolower(now()->parse($fecha)->locale('es')->dayName);

        $horarios = $doctor->horarios()
                           ->where('dia', $dia)
                           ->where('activo', true)
                           ->get();

        $citasOcupadas = Cita::where('doctor_id', $request->doctor_id)
                             ->whereDate('fecha', $fecha)
                             ->where('estado', '!=', 'cancelada')
                             ->pluck('hora_inicio');

        return response()->json([
            'horarios'      => $horarios,
            'ocupadas'      => $citasOcupadas,
            'duracion'      => $doctor->especialidad->duracion_consulta,
        ]);
    }
}