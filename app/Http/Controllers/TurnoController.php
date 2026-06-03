<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\Ventanilla;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::with(['paciente', 'servicio', 'ventanilla'])
                       ->orderBy('numero_turno')
                       ->get();
        return view('turnos.index', compact('turnos'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $servicios = Servicio::where('activo', true)->get();
        return view('turnos.create', compact('pacientes', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        $ultimo = Turno::whereDate('created_at', today())->max('numero_turno');
        $numero = $ultimo ? $ultimo + 1 : 1;

        Turno::create([
            'numero_turno' => $numero,
            'paciente_id'  => $request->paciente_id,
            'servicio_id'  => $request->servicio_id,
            'estado'       => 'esperando',
        ]);

        return redirect()->route('turnos.index')
                         ->with('success', 'Turno asignado correctamente');
    }

    public function show(Turno $turno)
    {
        return view('turnos.show', compact('turno'));
    }

    public function edit(Turno $turno)
    {
        $ventanillas = Ventanilla::where('estado', 'activa')->get();
        return view('turnos.edit', compact('turno', 'ventanillas'));
    }

    public function update(Request $request, Turno $turno)
    {
        $request->validate([
            'estado' => 'required|in:esperando,en_atencion,completado,ausente',
        ]);

        $turno->modificar($request->estado);
        return redirect()->route('turnos.index')
                         ->with('success', 'Turno actualizado correctamente');
    }

    public function destroy(Turno $turno)
    {
        $turno->delete();
        return redirect()->route('turnos.index')
                         ->with('success', 'Turno eliminado correctamente');
    }
}