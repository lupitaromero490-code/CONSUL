<?php

namespace App\Http\Controllers;

use App\Models\Ventanilla;
use App\Models\User;
use Illuminate\Http\Request;

class VentanillaController extends Controller
{
    public function index()
    {
        $ventanillas = Ventanilla::with('operador')->get();
        return view('ventanillas.index', compact('ventanillas'));
    }

    public function create()
    {
        $operadores = User::all();
        return view('ventanillas.create', compact('operadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'numero'  => 'required|integer|min:1',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Ventanilla::create($request->all());
        return redirect()->route('ventanillas.index')
                         ->with('success', 'Ventanilla registrada correctamente');
    }

    public function show(Ventanilla $ventanilla)
    {
        return view('ventanillas.show', compact('ventanilla'));
    }

    public function edit(Ventanilla $ventanilla)
    {
        $operadores = User::all();
        return view('ventanillas.edit', compact('ventanilla', 'operadores'));
    }

    public function update(Request $request, Ventanilla $ventanilla)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'numero'  => 'required|integer|min:1',
            'estado'  => 'required|in:activa,inactiva,en_pausa',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $ventanilla->update($request->all());
        return redirect()->route('ventanillas.index')
                         ->with('success', 'Ventanilla actualizada correctamente');
    }

    public function destroy(Ventanilla $ventanilla)
    {
        $ventanilla->delete();
        return redirect()->route('ventanillas.index')
                         ->with('success', 'Ventanilla eliminada correctamente');
    }
}