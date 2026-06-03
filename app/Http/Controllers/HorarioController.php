<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Doctor;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $doctor = $user->doctor;
        $horarios = Horario::where('doctor_id', $doctor->id)->get();
        return view('horarios.index', compact('horarios', 'doctor'));
    }

    public function create()
    {
        $user = auth()->user();
        $doctor = $user->doctor;
        return view('horarios.create', compact('doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'       => 'required|exists:doctores,id',
            'dia'             => 'required|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'hora_inicio'     => 'required',
            'hora_fin'        => 'required|after:hora_inicio',
            'margen_minutos'  => 'required|integer|min:0',
        ]);

        Horario::create($request->all());
        return redirect()->route('horarios.index')
                         ->with('success', 'Horario registrado correctamente');
    }

    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'dia'            => 'required|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'hora_inicio'    => 'required',
            'hora_fin'       => 'required|after:hora_inicio',
            'margen_minutos' => 'required|integer|min:0',
        ]);

        $horario->update($request->all());
        return redirect()->route('horarios.index')
                         ->with('success', 'Horario actualizado correctamente');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')
                         ->with('success', 'Horario eliminado correctamente');
    }

    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }
}