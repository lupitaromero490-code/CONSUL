<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_consulta',
        'activo'
    ];

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function doctores()
    {
        return $this->hasMany(Doctor::class);
    }

    public function consulta()
    {
        return self::where('activo', true)->get();
    }
}