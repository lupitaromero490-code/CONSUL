<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DoctorController extends Controller
{
    public function index()
    {
        $doctores = Doctor::with(['user', 'especialidad'])->get();
        return view('doctores.index', compact('doctores'));
    }

    public function create()
    {
        $especialidades = Especialidad::where('activo', true)->get();
        return view('doctores.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:8',
            'especialidad_id'  => 'required|exists:especialidades,id',
            'cedula'           => 'required|string|unique:doctores',
            'telefono'         => 'nullable|string',
            'celular'          => 'nullable|string',
            'descripcion'      => 'nullable|string',
        ]);

        // Crear usuario con rol doctor
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => 'doctor',
        ]);

        // Crear doctor
        Doctor::create([
            'user_id'         => $user->id,
            'especialidad_id' => $request->especialidad_id,
            'cedula'          => $request->cedula,
            'telefono'        => $request->telefono,
            'celular'         => $request->celular,
            'descripcion'     => $request->descripcion,
        ]);

        return redirect()->route('doctores.index')
                         ->with('success', 'Doctor registrado correctamente');
    }

    public function show(Doctor $doctor)
    {
        $citas = $doctor->citas()->with('paciente')->orderBy('fecha')->get();
        return view('doctores.show', compact('doctor', 'citas'));
    }

    public function edit(Doctor $doctor)
    {
        $especialidades = Especialidad::where('activo', true)->get();
        return view('doctores.edit', compact('doctor', 'especialidades'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'especialidad_id' => 'required|exists:especialidades,id',
            'cedula'          => 'required|string|unique:doctores,cedula,'.$doctor->id,
            'telefono'        => 'nullable|string',
            'celular'         => 'nullable|string',
            'descripcion'     => 'nullable|string',
        ]);

        $doctor->user->update(['name' => $request->name]);
        $doctor->update($request->except(['name', 'email', 'password']));

        return redirect()->route('doctores.index')
                         ->with('success', 'Doctor actualizado correctamente');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();
        return redirect()->route('doctores.index')
                         ->with('success', 'Doctor eliminado correctamente');
    }
}