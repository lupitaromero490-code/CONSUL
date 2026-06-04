<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|confirmed|min:8',
            'telefono'          => 'nullable|string|max:15',
            'fecha_nacimiento'  => 'nullable|date',
            'direccion'         => 'nullable|string|max:255',
            'alergias'          => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name'             => $request->nombre . ' ' . $request->apellido,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'rol'              => 'paciente',
            'telefono'         => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion'        => $request->direccion,
            'alergias'         => $request->alergias,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}