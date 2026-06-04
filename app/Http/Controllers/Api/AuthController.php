<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Generar token al iniciar sesión
    function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'mensaje' => 'Credenciales incorrectas',
            ], 401);
        }

        // Eliminar tokens anteriores
        $user->tokens()->delete();

        // Generar nuevo token
        $token = $user->createToken('consul-token-' . $user->rol)->plainTextToken;

        return response()->json([
            'mensaje' => 'Sesión iniciada correctamente',
            'token'   => $token,
            'usuario' => [
                'id'     => $user->id,
                'nombre' => $user->name,
                'correo' => $user->email,
                'rol'    => $user->rol,
            ],
        ]);
    }

    // Cerrar sesión y revocar token
    function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada correctamente',
        ]);
    }

    // Obtener información del usuario autenticado
    function usuario(Request $request)
    {
        return response()->json([
            'usuario' => [
                'id'     => $request->user()->id,
                'nombre' => $request->user()->name,
                'correo' => $request->user()->email,
                'rol'    => $request->user()->rol,
            ],
        ]);
    }
}