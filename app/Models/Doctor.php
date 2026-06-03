<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctores';

    protected $fillable = [
        'user_id',
        'especialidad_id',
        'cedula',
        'telefono',
        'celular',
        'descripcion',
        'activo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function consulta()
    {
        return self::with(['user', 'especialidad'])
                   ->where('activo', true)->get();
    }
}