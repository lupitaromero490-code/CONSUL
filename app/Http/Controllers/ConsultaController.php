<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Cita;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsultaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->esDoctor()) {
            $consultas = Consulta::whereHas('cita', function($q) use ($user) {
                $q->where('doctor_id', $user->doctor->id);
            })->with(['cita.paciente', 'cita.doctor.user'])->get();
        } else {
            $consultas = Consulta::with(['cita.paciente', 'cita.doctor.user'])->get();
        }

        return view('consultas.index', compact('consultas'));
    }

    public function create(Cita $cita)
    {
        return view('consultas.create', compact('cita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cita_id'          => 'required|exists:citas,id',
            'sintomas'         => 'required|string',
            'diagnostico'      => 'required|string',
            'peso'             => 'nullable|numeric',
            'talla'            => 'nullable|numeric',
            'presion_arterial' => 'nullable|string',
            'receta'           => 'nullable|string',
            'notas_pendientes' => 'nullable|string',
        ]);

        Consulta::create($request->all());

        // Marcar cita como completada
        $cita = Cita::find($request->cita_id);
        $cita->modificar('completada');

        return redirect()->route('consultas.index')
                         ->with('success', 'Consulta registrada correctamente');
    }

    public function show(Consulta $consulta)
    {
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        return view('consultas.edit', compact('consulta'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $request->validate([
            'sintomas'         => 'required|string',
            'diagnostico'      => 'required|string',
            'receta'           => 'nullable|string',
            'notas_pendientes' => 'nullable|string',
        ]);

        $consulta->modificar($request->all());
        return redirect()->route('consultas.index')
                         ->with('success', 'Consulta actualizada correctamente');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('consultas.index')
                         ->with('success', 'Consulta eliminada correctamente');
    }

    public function pdf(Consulta $consulta)
    {
        $pdf = Pdf::loadView('consultas.pdf', compact('consulta'));
        return $pdf->download('consulta-'.$consulta->id.'.pdf');
    }
}