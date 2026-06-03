<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'cita_id',
        'peso',
        'talla',
        'presion_arterial',
        'sintomas',
        'diagnostico',
        'receta',
        'notas_pendientes'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function modificar($datos)
    {
        $this->sintomas = $datos['sintomas'];
        $this->diagnostico = $datos['diagnostico'];
        $this->receta = $datos['receta'];
        $this->notas_pendientes = $datos['notas_pendientes'];
        $this->save();
    }
}