<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReplicaService
{
    // Sincronizar datos de MySQL a PostgreSQL
    function sincronizar($tabla, $datos)
    {
        try {
            DB::connection('pgsql')->table($tabla)->insert($datos);
            return true;
        } catch (\Exception $e) {
            Log::error('Error al sincronizar réplica: ' . $e->getMessage());
            return false;
        }
    }

    // Consultar con alta disponibilidad
    // Si MySQL falla, usa PostgreSQL como respaldo
    function consultar($tabla, $condiciones = [])
    {
        try {
            $query = DB::connection('mysql')->table($tabla);
            foreach ($condiciones as $campo => $valor) {
                $query->where($campo, $valor);
            }
            return $query->get();
        } catch (\Exception $e) {
            Log::warning('MySQL no disponible, usando réplica PostgreSQL');
            try {
                $query = DB::connection('pgsql')->table($tabla);
                foreach ($condiciones as $campo => $valor) {
                    $query->where($campo, $valor);
                }
                return $query->get();
            } catch (\Exception $e2) {
                Log::error('Ambas bases de datos no disponibles: ' . $e2->getMessage());
                return collect([]);
            }
        }
    }

    // Verificar estado de las conexiones
    function verificarConexiones()
    {
        $estado = [];

        try {
            DB::connection('mysql')->getPdo();
            $estado['mysql'] = 'activo';
        } catch (\Exception $e) {
            $estado['mysql'] = 'inactivo';
        }

        try {
            DB::connection('pgsql')->getPdo();
            $estado['pgsql'] = 'activo';
        } catch (\Exception $e) {
            $estado['pgsql'] = 'inactivo';
        }

        return $estado;
    }
}